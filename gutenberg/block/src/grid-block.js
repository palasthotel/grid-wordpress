const React = wp.element;
const {Component} = React;



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

class GutenbergGridContainer extends Component{
    constructor( props ) {
	    super(props);

	    this.state = {
	        index: 0,
        };

    }

    componentDidMount(){
        console.log("Index is", this.getIndex());
    }

    getIndex(){
        let myIndex = undefined;
        const containers = document.querySelectorAll(".grid-container");
        containers.forEach((container, index)=>{
	        console.log(this.el, container, index);
	            if(container.isSameNode(this.el)){
	                myIndex = index;
	            }
        });
        this.setState({index: myIndex});
        return myIndex;
    }

    render() {
        const {index} = this.state;
        return (
	        <div ref={el => this.el = el} className="grid-container">
                {index} This will be a GRID Container type {this._type}
	        </div>
        );
    }
}

GridGutenberg.containertypes.forEach( (containertype) => {
    registerBlockType('palasthotel/the-grid-container-'+containertype.type, {
        title: 'Grid Container '+containertype.type,
        icon: 'grid-view', // TODO change icon according to container type
        category: 'layout',
        // do not edit render html of grid in editor
        html: false,
        edit(props) {
            console.log("EDIT");
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
