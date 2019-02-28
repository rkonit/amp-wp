/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import { PanelBody, SelectControl } from '@wordpress/components';
import { RichText, InspectorControls, FontSizePicker, withFontSizes } from '@wordpress/editor';

/**
 * Internal dependencies
 */
import getTagName from './get-tag-name';
import { AMP_STORY_FONTS } from '../../helpers';

function TextBlock( {
	attributes,
	setAttributes,
	className,
	fontSize,
	setFontSize,
} ) {
	const { placeholder, content, type, ampFontFamily } = attributes;
	const tagName = getTagName( attributes );

	const fontSizeClass = fontSize.class || undefined;

	return (
		<Fragment>
			<InspectorControls>
				<PanelBody title={ __( 'Text Settings', 'amp' ) }>
					<SelectControl
						key={ 'font-family' }
						label={ __( 'Font family', 'amp' ) }
						value={ ampFontFamily }
						options={ AMP_STORY_FONTS }
						onChange={ function( value ) {
							setAttributes( { ampFontFamily: value } );
						} }
					/>
					<FontSizePicker
						value={ fontSize.size }
						onChange={ setFontSize }
					/>
					<SelectControl
						label={ __( 'Select text type', 'amp' ) }
						value={ type }
						onChange={ ( selected ) => setAttributes( { type: selected } ) }
						options={ [
							{ value: 'auto', label: __( 'Automatic', 'amp' ) },
							{ value: 'p', label: __( 'Paragraph', 'amp' ) },
							{ value: 'h1', label: __( 'Heading 1', 'amp' ) },
							{ value: 'h2', label: __( 'Heading 2', 'amp' ) },
						] }
					/>
				</PanelBody>
			</InspectorControls>
			<RichText
				identifier="content"
				wrapperClassName="wp-block-amp-story-text"
				tagName={ tagName }
				value={ content }
				onChange={ ( value ) => setAttributes( { content: value } ) }
				style={ {
					fontSize: fontSize.size ? fontSize.size + 'px' : undefined,
				} }
				className={ `${ className } ${ fontSizeClass }` }
				placeholder={ placeholder || __( 'Write text…', 'amp' ) }
			/>
		</Fragment>
	);
}

export default withFontSizes( 'fontSize' )( TextBlock );
