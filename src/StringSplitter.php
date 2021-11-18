<?php

namespace SiteOrigin\StringSplitter;

/**
 * Find all words in a given string without spaces.
 */
class StringSplitter
{
    private string $string;

    private array $words;

    private array $stacks;

    private ?int $shortestStack = null;

    /**
     * @var array|int[]
     */
    private array $options;

    public function __construct(string $string, $options = [])
    {
        $this->options = array_merge([
            'length_penalty' => 1.5,
            'frequency_scaling' => 1.2,
        ], $options);
        $this->string = $string;
    }

    /**
     * Get words for a given string.
     *
     * @return array
     */
    public function split(): array
    {
        $string = strtolower($this->string);
        $this->words = $this->allWords();
        $this->stacks = [];

        $this->findStacks($string, []);

        // Return the words
        if (empty($this->stacks)) {
            return [];
        }

        // Stacks are stored with their score
        arsort($this->stacks);

        return ! empty($this->stacks) ? explode('-', array_keys($this->stacks)[0]) : [$string];
    }

    /**
     * All the words present in the current string.
     *
     * @return array
     */
    private function allWords(): array
    {
        static $words = null;
        if (is_null($words)) {
            $words = json_decode(file_get_contents(__DIR__.'/../data/words.json'), true);
        }

        $all = array_filter(
            $words,
            fn ($word) => str_contains($this->string, $word),
            ARRAY_FILTER_USE_KEY
        );

        return array_map(fn ($weight) => log($weight, $this->options['frequency_scaling']), $all);
    }

    /**
     * Score a string based on frequency of words.
     *
     * @param array $stack
     * @return float
     */
    private function scoreStack(array $stack): float
    {
        $weights = array_map(fn ($w) => $this->words[$w], $stack);

        return array_sum($weights) / pow(count($weights), $this->options['length_penalty']);
    }

    /**
     * Find the stacks for the given string
     *
     * @param $string
     * @param array $stack
     * @return $this
     */
    private function findStacks($string, array $stack = [])
    {
        $found = array_filter(
            $this->words,
            fn ($w) => str_starts_with($string, $w),
            ARRAY_FILTER_USE_KEY
        );

        // If this is the end, add to the stack
        foreach (array_keys($found) as $word) {
            if ($word == $string) {
                $finalStack = array_merge($stack, [$word]);
                $this->stacks[implode('-', $finalStack)] = $this->scoreStack($finalStack);

                if (is_null($this->shortestStack) || count($finalStack) < $this->shortestStack) {
                    $this->shortestStack = count($finalStack);
                }
            }
        }

        if (empty($this->stacks) || count($stack) < $this->shortestStack + 1) {
            // If no stacks have been found, then search one level deeper
            foreach (array_keys($found) as $word) {
                $this->findStacks(substr($string, strlen($word)), array_merge($stack, [$word]));
            }
        }
    }
}
