<?php
declare( strict_types = 1 );

namespace Wikimedia\LittleWikitext\Tests\ParserTests;

class TestFileReader {
	/** @var TestItem[] */
	public $testCases = [];

	/**
	 * Read and parse a parserTest file.
	 * @param string $testFilePath The parserTest file to read
	 * @return TestItem[]
	 */
	public static function read(
		string $testFilePath
	): array {
		$reader = new self(
			$testFilePath
		);
		return $reader->testCases;
	}

	/**
	 * @param string $testFilePath The parserTest file to read
	 */
	private function __construct(
		string $testFilePath
	) {
		$rawTestItems = Grammar::load( $testFilePath );

		$testNames = [];

		$lastComment = '';
		foreach ( $rawTestItems as $item ) {
			if ( $item['type'] === 'test' ) {
				$test = new TestItem(
					$item,
					$lastComment
				);
				$testName = $test->testName ?? '<unknown>';
				if ( isset( $testNames[$testName] ) ) {
					$test->error( 'Duplicate test name', $testName );
				}
				$testNames[$testName] = true;
				$this->testCases[] = $test;
				$lastComment = '';
			} elseif ( $item['type'] === 'comment' ) {
				$lastComment .= $item['text'];
			} elseif ( $item['type'] === 'line' ) {
				if ( trim( $item['text'] ?? '' ) !== '' ) {
					( new Item( $item ) )->error( 'Invalid line', $item['text'] );
				}
			} else {
				( new Item( $item ) )->error( 'Unknown item type', $item['type'] );
			}
		}
	}
}
