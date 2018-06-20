/**
 * Gutenpride
 * A gutenberg block that displays a powered by Gutenberg message
 */

const {__} = wp.i18n;
const {registerBlockType} = wp.blocks;


// https://github.com/WordPress/gutenberg/blob/master/editor/components/block-list/index.js#L21
// https://github.com/WordPress/gutenberg/blob/master/docs/block-api.md
// https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
// https://wordpress.org/gutenberg/handbook/blocks/creating-dynamic-blocks/

class GutenbergGridContainer {
    constructor( type ) {
        this._type = type;
        this._clicked = 0;
    }

    render() {
        return (
            <div>
                This will be a GRID Container type {this._type}
            </div>
        )
    }
}

GridGutenberg.containertypes.map( (containertype, i) => {
    registerBlockType('palasthotel/the-grid-container-'+containertype.type, {
        title: 'Grid Container '+containertype.type,
        icon: 'grid-view', // TODO change icon according to container type
        category: 'layout',
        // do not edit render html of grid in editor
        html: false,
        edit(props) {

            const grid_container = new GutenbergGridContainer( containertype.type );

            return grid_container.render();
        },
        save(props) {
            return (
                <div>
                    This will be a GRID Container save // TODO maybe render in php like dynamic block
                </div>
            );
        },
    });
})
