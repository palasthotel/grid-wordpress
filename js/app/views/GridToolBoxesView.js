var GridToolBoxesView = Backbone.View.extend({
    className: "g-tool g-box clearfix",
    events:{
    	"click .box-type-tabs li": "searchBoxes"
    },
    initializes: function(){
    	this.render();
    },
    render: function(){
    	var self = this;
        this.$el.html(ich.tpl_toolBoxes());
        this.collection.each(function(boxtype, index){
        	GRID.log(["type tab", boxtype, index]);
        	jQuery("<li></li>").attr("data-index",index).attr("title", boxtype.get("title") ).attr("data-type", boxtype.get("type") ).appendTo(self.$el.find(".box-type-tabs"));
        });
        this.$el.find(".box-type-tabs li").first().trigger("click");
        return this;
    },
    searchBoxes: function(event){
    	GRID.log(["searchBoxes",event]);
        this.$el.find(".box-list").empty();
        this.$el.find(".box-type-tabs li").removeClass('active');
    	var $li = jQuery(event.target);
        $li.addClass('active');
    	var boxtype = this.collection.at($li.data("index"));
    	this.blueprints = boxtype.searchBoxes();
        this.listenTo(this.blueprints ,"add", this.buildBoxlist);
        
    },
    buildBoxlist: function(blueprint,collection,event){
        GRID.log(["buildBoxlist", this.blueprints, blueprint]);
        var json = blueprint.toJSON();
        json.cid = blueprint.cid;
        this.$el.find(".box-list").append(ich.tpl_toolBoxBlueprint(json));
        this.initializesDraggable();
    },
    initializesDraggable: function(){
        var self = this;
        this.$el.find(".box-dragger").draggable({ 
            helper: function(event, element){
                return jQuery("<div class='dragger-helper'></div>");
            },
            cursorAt: { left: 30, top:30 },
            zIndex: 199,
            appendTo: GRID.getView().$el,
            addClass: true,
            //connectToSortable: GRID_SORTABLE,
            start: function(event, ui){
                
                var $ = jQuery;
                $slots = jQuery(GRID.getView().el).find(".container[data-reused=false][data-type*=C-] .slot .boxes-wrapper");
                GRID.log($slots);
                // drop place template
                // TODO: if boxes toggled hidden 
                // var $toggle_btn = $toolbar.find("[role=hide_boxes]");

                $slots.children(".box").before($( document.createElement('div'))
                                .addClass("box-drop-area-wrapper"));
                $slots.append($( document.createElement('div'))
                                .addClass("box-drop-area-wrapper"));
                $slots.find(".box-drop-area-wrapper").append($( document.createElement('div'))
                                .addClass("box-drop-area"));
                
                $slots.find(".box-drop-area").droppable({ 
                    accept: ".box-dragger",
                    hoverClass: "hover",
                    drop: function( event, ui ) {
                        var $this_box = $(ui.draggable);
                        var $this_drop = $(this);
                        var $this_slot = $this_drop.parents(".slot");
                        var $this_container = $this_slot.parents(".container");
                        var slot = GRID.getModel().getContainers().get($this_container.data("id")).getSlots().get($this_slot.data("id"));
                        var blueprint = self.blueprints.get($this_box.data("cid"));

                        $new_box = $this_drop.parent().addClass('new-box-place').removeClass('box-drop-area-wrapper');
                        GRID.getView().remove(".box-drop-area-wrapper");

                        GRID.log(["DROPPED Box", $this_box.data("cid"), $this_drop, $this_slot, $this_container, slot, blueprint]);
                        var box = slot.createBox(blueprint, $new_box.index() );
                        // box_obj = arr_box_search_results[$this_box.data("index")];
                        
                        // $temp = buildBox( 
                        //         [{  
                        //             id : box_obj.id,
                        //             title: box_obj.title, 
                        //             titleurl: box_obj.titleurl,
                        //             prolog: box_obj.prolog,
                        //             html: box_obj.html,
                        //             epilog: box_obj.epilog,
                        //             readmore: box_obj.readmore,
                        //             readmoreurl: box_obj.readmoreurl,
                        //             type: box_obj.type
                        //         }] ).insertBefore( $this_drop.parent() );
                        // $grid.find(".box-drop-area-wrapper").remove();
                        // params = [ID, $this_container.data("id"), $this_slot.data("id"), $temp.index(), box_obj.type, box_obj.content];
                        // console.log(params);
                        // sendAjax("createBox",params,
                        // function(data){
                        //     $temp.attr("data-id",data.result.id);
                        //     console.log(data);
                        //     $grid.trigger("structureChange");
                        //     scrollToBox(data.result.id);
                        // });
                    }
                });
                
            },
            stop: function( event, ui ){
                GRID.getView().$el.find(".box-drop-area-wrapper").remove();
            }
        });
    }
});

