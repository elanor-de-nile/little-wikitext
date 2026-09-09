<?php
declare( strict_types = 1 );

namespace Wikimedia\LittleWikitext\Visitors;

use Wikimedia\LittleWikitext\AST\Heading;
use Wikimedia\LittleWikitext\AST\Inclusion;
use Wikimedia\LittleWikitext\AST\Link;
use Wikimedia\LittleWikitext\AST\ListItem;
use Wikimedia\LittleWikitext\AST\Paragraph;
use Wikimedia\LittleWikitext\AST\Root;
use Wikimedia\LittleWikitext\AST\Section;
use Wikimedia\LittleWikitext\AST\Text;

/**
 * Visitor class for transforming the AST.
 *
 * This is a helper class which provides default visitor behavior to make
 * it easier to write AST-to-AST transformations.
 */
class TransformVisitor extends Visitor {

	/** @inheritDoc */
	public function visitHeading( Heading $node, ...$args ) {
		return new Heading(
			$this->visitNodes( $node->getChildren(), ...$args )
		);
	}

	/** @inheritDoc */
	public function visitInclusion( Inclusion $node, ...$args ) {
		// Leaf node
		return $node;
	}

	/** @inheritDoc */
	public function visitLink( Link $node, ...$args ) {
		return new Link(
			$node->getTarget(),
			$this->visitNodes( $node->getChildren(), ...$args )
		);
	}

	/** @inheritDoc */
	public function visitListItem( ListItem $node, ...$args ) {
		return new ListItem(
			$node->getLevel(),
			$this->visitNodes( $node->getChildren(), ...$args )
		);
	}

	/** @inheritDoc */
	public function visitParagraph( Paragraph $node, ...$args ) {
		return new Paragraph(
			$this->visitNodes( $node->getChildren(), ...$args )
		);
	}

	/** @inheritDoc */
	public function visitRoot( Root $node, ...$args ) {
		return new Root(
			$this->visitNodes( $node->getChildren(), ...$args )
		);
	}

	/** @inheritDoc */
	public function visitSection( Section $node, ...$args ) {
		$heading = $node->getHeading();
		return new Section(
			$heading !== null ? $this->visitHeading( $heading ) : null,
			$this->visitNodes( $node->getChildren(), ...$args )
		);
	}

	/** @inheritDoc */
	public function visitText( Text $node, ...$args ) {
		// Leaf node
		return $node;
	}

}
