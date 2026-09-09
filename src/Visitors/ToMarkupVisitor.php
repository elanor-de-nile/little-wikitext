<?php
declare( strict_types = 1 );

namespace Wikimedia\LittleWikitext\Visitors;

use Wikimedia\LittleWikitext\AST\Heading;
use Wikimedia\LittleWikitext\AST\Inclusion;
use Wikimedia\LittleWikitext\AST\Link;
use Wikimedia\LittleWikitext\AST\ListItem;
use Wikimedia\LittleWikitext\AST\Node;
use Wikimedia\LittleWikitext\AST\Paragraph;
use Wikimedia\LittleWikitext\AST\Root;
use Wikimedia\LittleWikitext\AST\Section;
use Wikimedia\LittleWikitext\AST\Text;

/**
 * Visitor class for serializing the AST as markup.
 */
class ToMarkupVisitor extends Visitor {

	/**
	 * Convert a node to a markup string.
	 * @param Node $node
	 * @return string markup string
	 */
	public static function toMarkup( Node $node ): string {
		$visitor = new self();
		return $visitor->visit( $node );
	}

	/** @inheritDoc */
	public function visitHeading( Heading $node, ...$args ) {
		$children = implode( $this->visitNodes( $node->getChildren() ) );
		return "== $children ==";
	}

	/** @inheritDoc */
	public function visitInclusion( Inclusion $node, ...$args ) {
		$target = $node->getTarget();
		return "{{" . $target . "}}";
	}

	/** @inheritDoc */
	public function visitLink( Link $node, ...$args ) {
		$target = $node->getTarget();
		$children = implode( $this->visitNodes( $node->getChildren() ) );
		return "[[$target|$children]]";
	}

	/** @inheritDoc */
	public function visitListItem( ListItem $node, ...$args ) {
		$stars = str_repeat( '*', $node->getLevel() );
		$children = implode( $this->visitNodes( $node->getChildren() ) );
		return "$stars $children";
	}

	/** @inheritDoc */
	public function visitParagraph( Paragraph $node, ...$args ) {
		$children = implode( $this->visitNodes( $node->getChildren() ) );
		return $children;
	}

	/** @inheritDoc */
	public function visitRoot( Root $node, ...$args ) {
		$children = implode( $this->visitNodes( $node->getChildren() ) );
		return $children;
	}

	/** @inheritDoc */
	public function visitSection( Section $node, ...$args ) {
		$result = [];
		$heading = $node->getHeading();
		if ( $heading !== null ) {
			$result[] = $this->visit( $heading ) . "\n";
		}
		foreach ( $node->getChildren() as $child ) {
			$result[] = $this->visit( $child ) . "\n";
		}
		return implode( $result );
	}

	/** @inheritDoc */
	public function visitText( Text $node, ...$args ) {
		return $node->getValue();
	}

}
