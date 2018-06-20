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
    let rects = [];
    for (let i = 0; i < columns; i++) {
        rects.push(<rect x={2*i} fill="silver" width="2" height="2"/>);
    }
    return (
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">{rects}</svg>
    )
}

GridGutenberg.containertypes.forEach( (containertype) => {
    registerBlockType('palasthotel/the-grid-container-'+containertype.type, {
        title: 'Grid Container '+containertype.type,
        icon: container_icon(containertype.numslots, containertype.type), // TODO change accpording to container type
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
