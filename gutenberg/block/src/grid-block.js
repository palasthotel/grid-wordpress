const React = wp.element;
const {Component} = React;

/**
 * Gutenpride
 * A gutenberg block that displays a powered by Gutenberg message
 */

const {__} = wp.i18n;
const {registerBlockType} = wp.blocks;

let Grid = [];
window.Grid = Grid;
setInterval(()=>{
	// TODO: please find a more efficient way
	Grid.forEach((container)=> container.updateIndex());
},300);

// https://github.com/WordPress/gutenberg/blob/master/editor/components/block-list/index.js#L21
// https://github.com/WordPress/gutenberg/blob/master/docs/block-api.md
// https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
// https://wordpress.org/gutenberg/handbook/blocks/creating-dynamic-blocks/

class GutenbergGridContainer extends Component{
    constructor( props ) {
	    super( ...arguments );
	    this.state = {
	        index: 0,
        };
    }

    componentDidMount(){
        Grid.push(this);
    }

    componentWillUnmount(){
        Grid = Grid.filter((container) => {
            return container.el !== null;
        });
    }

    getIndex(){
        let myIndex = undefined;
        const containers = document.querySelectorAll(".grid-container");
        containers.forEach((container, index)=>{
	            if(container.isSameNode(this.el)){
	                myIndex = index;
	            }
        });
        return myIndex;
    }

    updateIndex(){
        this.setState({index: this.getIndex()})
    }

    render() {
        const {index} = this.state;
        return (
	        <div ref={el => this.el = el} className="grid-container">
                {index} This will be a GRID Container type {this.props.type}
	        </div>
        );
    }
}

const container_icon = (columns, type) => {
    const grid_slots = type.split('-');
    const slot_gap = 2;
    const width = 60 - ((parseInt(columns)-1) * slot_gap);
    let rects = [];
    let x = 0;
    for (let i = 0; i < columns; i++) {
        let slot_width = 0;
        slot_width = grid_slots[i].replace(/d/g, '/');
        const numbers = slot_width.split('/');
        slot_width = parseInt(numbers[0]) / parseInt(numbers[1]) * width;
        rects.push(<rect x={x} fill="silver" width={slot_width} height="100%"/>);
        x = x + slot_width + slot_gap;
    }
    return (
        <svg xmlns="http://www.w3.org/2000/svg" style={{width:"100%"}}>{rects}</svg>
    )
}

GridGutenberg.containertypes.forEach( (containertype) => {
    const icon_type = containertype.type.replace("c-", "");
    const name = icon_type.replace(/d/g, '/');
    registerBlockType('palasthotel/the-grid-container-'+containertype.type, {
        title: 'Grid Container '+name,
        icon: container_icon(containertype.numslots, icon_type),
        category: 'layout',
        // do not edit render html of grid in editor
        html: false,
        edit(props) {
            return <GutenbergGridContainer type={containertype.type}/>;
        },
        save(props) {
            return (
                <div>
                    This will be a GRID Container save // TODO maybe render in php like dynamic block
                </div>
            );
        },
    });
});
