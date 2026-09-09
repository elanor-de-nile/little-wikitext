<?php
declare( strict_types = 1 );

namespace Wikimedia\LittleWikitext\AST;

use Wikimedia\LittleWikitext\Visitors\Visitor;

/**
 * The ListItem class represents a wikitext list item.
 *
 * ListItem contains Inclusion, Link, and/or Text nodes as children.
 */
class ListItem extends Node {
	/** @var int */
	protected $level;

	/**
	 * @param int $level
	 * @param array $children
	 */
	public function __construct( int $level, array $children ) {
		parent::__construct( $children );
		$this->level = $level;
	}

	/**
	 * Return the nesting level of this list item.
	 * @return int The nesting level
	 */
	public function getLevel(): int {
		return $this->level;
	}

	/** @inheritDoc */
	public function accept( Visitor $visitor, ...$args ) {
		return $visitor->visitListItem( $this, ...$args );
	}
}
