<?php

require_once( dirname( __FILE__ ) . '/class-amp-base-sanitizer.php' );
require_once( dirname( dirname( __FILE__ ) ) . '/utils/class-amp-image-dimension-extractor.php' );

/**
 * Converts <img> tags to <amp-img> or <amp-anim>
 */
class AMP_Img_Sanitizer extends AMP_Base_Sanitizer {
	public static $tag = 'img';

	private static $anim_extension = '.gif';

	private static $script_slug = 'amp-anim';
	private static $script_src = 'https://cdn.ampproject.org/v0/amp-anim-0.1.js';

	public function sanitize( $amp_attributes = array() ) {
		$nodes = $this->dom->getElementsByTagName( self::$tag );
		$num_nodes = $nodes->length;
		if ( 0 === $num_nodes ) {
			return;
		}

		for ( $i = $num_nodes - 1; $i >= 0; $i-- ) {
			$node = $nodes->item( $i );
			$old_attributes = AMP_DOM_Utils::get_node_attributes_as_assoc_array( $node );

			if ( ! array_key_exists( 'src', $old_attributes ) ) {
				$node->parentNode->removeChild( $node );
				continue;
			}

			$new_attributes = $this->filter_attributes( $old_attributes );
			$new_attributes = array_merge( $new_attributes, $amp_attributes );

			// Workaround for https://github.com/Automattic/amp-wp/issues/20
			// responsive + float don't mix
			if ( isset( $new_attributes['class'] )
				&& (
					false !== strpos( $new_attributes['class'], 'alignleft' )
					|| false !== strpos( $new_attributes['class'], 'alignright' )
				)
			) {
				unset( $new_attributes['layout'] );
			}

			if ( $this->url_has_extension( $new_attributes['src'], self::$anim_extension ) ) {
				$this->did_convert_elements = true;
				$new_tag = 'amp-anim';
			} else {
				$new_tag = 'amp-img';
			}

			$new_node = AMP_DOM_Utils::create_node( $this->dom, $new_tag, $new_attributes );
			$node->parentNode->replaceChild( $new_node, $node );
		}
	}

	public function get_scripts() {
		if ( ! $this->did_convert_elements ) {
			return array();
		}

		return array( self::$script_slug => self::$script_src );
	}

	private function filter_attributes( $attributes ) {
		$out = array();

		foreach ( $attributes as $name => $value ) {
			switch ( $name ) {
				case 'src':
				case 'alt':
				case 'width':
				case 'height':
				case 'class':
					$out[ $name ] = $value;
					break;
				default;
					break;
			}
		}

		if ( ! isset( $out['width'] ) || ! isset( $out['height'] ) ) {
			list( $width, $height ) = AMP_Image_Dimension_Extractor::extract( $out['src'] );
			if ( $width && $height ) {
				$out['width'] = $width;
				$out['height'] = $height;
			}
		}

		return $out;
	}
}
