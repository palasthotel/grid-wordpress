/**
 * Gutenpride
 * A gutenberg block that displays a powered by Gutenberg message
 */

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

const {TermTreeSelect} = wp.blocks;

const label = __( 'This post proudly created in' );


// https://github.com/WordPress/gutenberg/blob/master/editor/components/block-list/index.js#L21
// https://github.com/WordPress/gutenberg/blob/master/docs/block-api.md
// https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
// https://wordpress.org/gutenberg/handbook/blocks/creating-dynamic-blocks/

class Grid{
	constructor(){
		this._clicked = 0;
	}
	render(){
		return (
			<div>
				This will be a GRID
				<a onClick={this.clicked.bind(this)}>Click me! I was clicked {this._clicked} times</a>
			</div>
		)
	}
	clicked(){
		this._clicked++;
	}
}

let grid = null;

registerBlockType( 'palasthotel/the-grid', {
	title: 'Grid',
	icon: 'grid-view',
	category: 'layout',
	// only one grid per post allowed
	useOnce: true,
	// do not edit render html of grid in editor
	html: false,
	edit(props) {

		if(grid == null) grid = new Grid();

		return grid.render();
	},
	save(props) {
		return (
			<div>
				This will be a GRID save
			</div>
		);
	},
} );

registerBlockType( 'palasthotel/the-grid__posts', {
	title: 'Posts',
	icon: 'grid-view',
	category: 'layout',
	// do not edit render html of grid in editor
	html: false,
	edit(props) {

		return (<p>Grid box with posts</p>)
	},
	save(props) {
		return (
			<div>
				Grid box with posts
			</div>
		);
	},
} );
