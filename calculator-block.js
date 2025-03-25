/**
 * Bizpress Calculators Block
 */
import { registerBlockType } from "@wordpress/blocks";

//icon: 'calculator',

(function( blocks, components ) {
    var el = wp.element.createElement;
    var TextControl = components.TextControl;
    registerBlockType( 'bizpress/calculators', {
        title: 'Bizpress Calculators',
        category: 'widgets',
        attributes: {
            id: {
                type: 'string'
            }
        },
        edit: function( props ) {

            var attributes = props.attributes;
            function onIDChange( value ) {
                props.setAttributes( { id: value } );
            }
            return el(
                'div',
                { className: props.className },
                el(
                    TextControl,
                    {
                        label: 'Calculator ID',
                        value: attributes.id,
                        onChange: onIDChange
                    }
                )
            );
        },

        save: function() {
            return null;
        }

    } );

}(
    window.wp.blocks,
    window.wp.components
) );
