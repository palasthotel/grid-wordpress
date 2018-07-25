
// const React = require("../../../lib/node_modules/react");
const React = wp.element;
const { Component } = React;

import GridContainer from "../../../lib/src/component/the-grid/container/container-raw";

import GridSlot from "../../../lib/src/component/the-grid/slot/slot";

const {__} = wp.i18n;
const {registerBlockType} = wp.blocks;

class Gridenberg {
    constructor(){
        this.containers = [];
        this.isSaving = false;
        this.hasChanged = false;

        // Update container index
        setInterval(()=>{
	        this.containers.forEach((container)=> container.updateIndex());
        },330);
    }

    // save contents to grid
    save(){
        if(this.isSaving || !this.hasChanged) return;
        this.isSaving = true;

        setTimeout(()=>{
	        const containers = this.containers.map((container) => {
		        return {
			        index: container.getIndex(),
			        container
		        }
	        }).sort((a,b) => a.index - b.index);

	        console.log("save containers", containers);
			this.hasChanged = false;
	        this.isSaving = false;
        },3000);
    }

	addContainer(container){
		this.containers.push(container);
		this.hasChanged = true;
		this.save()
	}
	removeContainer(){
		this.containers = this.containers.filter((container) => {
			return container.el !== null;
		});
		this.hasChanged = true;
		this.save();
	}
}

const gridenberg = window.Gridenberg = new Gridenberg();




// https://github.com/WordPress/gutenberg/blob/master/editor/components/block-list/index.js#L21
// https://github.com/WordPress/gutenberg/blob/master/docs/block-api.md
// https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
// https://wordpress.org/gutenberg/handbook/blocks/creating-dynamic-blocks/

class GutenbergGridContainer extends Component{

    constructor(props) {
	    super(  );
	    this.state = {
	        index: 0,
        };
    }

    componentDidMount(){
	    gridenberg.addContainer(this);
    }

    componentWillUnmount(){
	    gridenberg.removeContainer();
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
    	const index = this.getIndex();
    	if(this.state.index !== index){
    		gridenberg.hasChanged = true;
		    this.setState({index})
		    gridenberg.save();
	    }

    }

    render() {
        const {index} = this.state;
        return (
	        <div ref={el => this.el = el} className="grid-container">
		        <GridContainer
		        index={index}>

		        </GridContainer>
                {/*<p>{index} This will be a GRID Container type {this.props.type}</p>*/}
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
            return <GutenbergGridContainer
                type={containertype.type}
            />;
        },
        save() {
        	console.log("SAVE");
	        gridenberg.save();
            return null;
        },
    });
});
