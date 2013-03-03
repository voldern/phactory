<?php
namespace Phactory\Type;

use Phactory\Generator\RandomInterface,
    Phactory\Exception\RuntimeException;

/**
 * Text field type
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Type
 */
class String extends Type implements RandomInterface {
    /**
     * Lorem ipsum used to generate random words and sentences
     *
     * @var string
     */
    private $lorem = <<<'EOD'
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras rhoncus mi vitae enim vulputate sagittis. Mauris ut massa et mi pellentesque varius. Vestibulum eu orci in mi luctus pharetra. Nullam eros turpis, fringilla nec molestie a, vestibulum non mi. Maecenas lorem sem, consectetur ut luctus non, placerat sit amet nibh. In sed metus eget arcu aliquet blandit non sed lacus. Suspendisse sollicitudin leo in quam consectetur in elementum augue porttitor. Duis commodo vestibulum velit. Suspendisse at justo eu lorem vehicula ultricies sed at eros. Duis pretium massa sed odio ultrices fermentum. Curabitur et dui ac elit condimentum lobortis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id arcu lacus. Phasellus tristique elit magna, et tempor lectus. Nunc aliquet, urna ac adipiscing convallis, metus tellus ornare tortor, ac bibendum arcu metus id diam. Nunc at tortor ut velit pretium consequat.
EOD;

    /**
     * {@inheritdoc}
     * @return string
     * @throws RuntimeException
     */
    public function generateRandom() {
        if (isset($this->config['values'])) {
            return (string) $this->randomStaticValue();
        }

        if (isset($this->config['words'])) {
            $wordCount = (int) $this->config['words'];
            return $this->generateRandomWords($wordCount);
        }

        if (isset($this->config['sentences'])) {
            $sentenceCount = (int) $this->config['sentences'];
            return $this->generateRandomSentences($sentenceCount);
        }

        throw new RuntimeException('Missing one of the following field config ' .
            'attributes: values, words, and sentences');
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public function generateStatic() {
        return (string) parent::generateStatic();
    }

    /**
     * Generates random words using lorem ipsum
     *
     * @throws RuntimException
     * @param int $count Number of words to generate
     * @return string
     */
    private function generateRandomWords($count) {
        if ($count < 1) {
            throw new RuntimeException('Word count cannot be zero or smaller');
        }

        $lorem = explode(' ', $this->lorem);

        if ($count > count($lorem)) {
            throw new RuntimeException('Word count cannot be larger then ' .
                count($lorem));
        }

        $words = array_slice($lorem, 0, $count);

        return implode(' ', $words);
    }

    /**
     * Generates random sentences using lorem ipsum
     *
     * @throws RuntimException
     * @param int $count Number of sentences to generate
     * @return string
     */
    private function generateRandomSentences($count) {
        if ($count < 1) {
            throw new RuntimeException('Sentence count cannot be zero or smaller');
        }

        $lorem = explode('.', $this->lorem);

        if ($count > count($lorem)) {
            throw new RuntimeException('Sentence count cannot be larger then ' .
                count($lorem));
        }

        $sentences = array_slice($lorem, 0, $count);

        return implode('.', $sentences) . '.';
    }
}