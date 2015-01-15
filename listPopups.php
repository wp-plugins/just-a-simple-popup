<?php

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class POPUP_LISTS extends WP_List_Table {    
   
    var $example_data = '';
    function __construct()
		{
			global $status, $page;
					
			//Set parent defaults
			parent::__construct( array(
				'singular'  => 'popup',     //singular name of the listed records
				'plural'    => 'popups',    //plural name of the listed records
				'ajax'      => false        //does this table support ajax?
			) );
			
		}

    function column_default($item, $column_name)
		{
			switch($column_name)
				{
					case 'name':
					case 'content':
					case 'home':
					case 'color':
					case 'opacity':
					case 'fadetime':
						return $item[$column_name];
					default:
						return print_r($item,true); //Show the whole array for troubleshooting purposes
				}
		}

    function column_name($item)
		{
			
			//Build row actions
			$actions = array(
				'edit'      => sprintf('<a href="?page=%s&action=%s&popupid=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
				'delete'    => sprintf('<a href="?page=%s&action=%s&popupid=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID']),
			);
			
			//Return the title contents
			return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
				/*$1%s*/ $item['name'],
				/*$2%s*/ $item['ID'],
				/*$3%s*/ $this->row_actions($actions)
			);
		}


    function column_cb($item)
		{
			return sprintf(
				'<input type="checkbox" name="%1$s[]" value="%2$s" />',
				/*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
				/*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
			);
		}

    function get_columns()
		{
			$columns = array(
				'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
				'name'     => 'Name',            
				
				'color'     => 'Color',            
				'fadetime'  => 'Fade Time',
				'home'     => 'Home',            
				'opacity'  => 'Opacity',
			);
			return $columns;
		}

 
    function get_sortable_columns()
		 {
			$sortable_columns = array(
				'name'     => array('name',false),     //true means it's already sorted
				'content'  => array('content',false),
				'color'  => array('color',false),
				'opacity'  => array('opacity',false),
				'fadetime'  => array('fadetime',false)				
			);
			return $sortable_columns;
		}


    function get_bulk_actions() 
		{
			$actions = array(
				'delete'=>'Delete'				
			);
			return $actions;
		}


    function process_bulk_action() 
		{
			
			//Detect when a bulk action is being triggered...
			if( 'delete'===$this->current_action() ) {
				if(count($_REQUEST['popup'])>0)
					{
						$ids=$_REQUEST['popup'];
						global $wpdb;
						foreach($ids as $singleId)
							wp_delete_post($singleId);
						 
					}
				
			}
			
		}


    function prepare_items($popups) {
        global $wpdb; //This is used only if making any database queries

        /**
         * First, lets decide how many records per page to show
         */
		 $this->example_data=$popups;
        $per_page = 10;      
     
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();       
       
        $this->_column_headers = array($columns, $hidden, $sortable);        
   
        $this->process_bulk_action();       
     
        $data = $this->example_data;
                
       
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'name'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');
     
        $current_page = $this->get_pagenum();
        
       
        $total_items = count($data);
        
      
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
      
        $this->items = $data;
       
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}