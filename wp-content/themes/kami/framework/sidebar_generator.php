<?php
/**
  * Name 			: Custom Sidebars Generator
  * Description: This plugin generates as many sidebars as you need. Then allows you to place them on any page you wish. Version 1.1 now supports themes with multiple sidebars. 
  * Version 		: 1.1.0
  * Author          : Kyle Getson
  * Author URI      : http://www.kylegetson.com
  * Copyright (C) 2009 Kyle Robert Getson
  */

add_action( 'after_setup_theme', 'bk_setup_custom_sidebar' );
function bk_setup_custom_sidebar() {
	add_action('init', array('sidebar_generator','init'));
	add_action('admin_menu', array('sidebar_generator','admin_menu'));
	add_action('admin_print_scripts', array('sidebar_generator','admin_print_scripts'));
	add_action('wp_ajax_add_sidebar', array('sidebar_generator','add_sidebar') );
	add_action('wp_ajax_remove_sidebar', array('sidebar_generator','remove_sidebar') );
}

class sidebar_generator {
	
	/**
	 * Initiate the function
	 *
	 * Hook the function on to specific actions.
	 *
	 * @since 	1.0
	 */
	function sidebar_generator(){
		
	}
	
	/**
	 * Register sidebars
	 *
	 * Go through each sidebar and register it
	 *
	 * @since 	1.0
	 */
	static function init(){
	
		$sidebars = sidebar_generator::get_sidebars();
		
		if(is_array($sidebars)){
			foreach($sidebars as $sidebar){
				$sidebar_class = sidebar_generator::name_to_class($sidebar);
				register_sidebar(array(
					'name'          => $sidebar,
            		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            		'after_widget' => '</aside>',
            		'before_title' => '<div class="bk-header"><div class="widget-title"><h3>',
            		'after_title' => '</h3></div></div>'
		    	));
			}
		}
	}
	
	/**
	 * Load WP Ajax
	 *
	 * Call WP admin AJAX and register js function for add/remove a sidebar
	 *
	 * @since 	1.0
	 */
	static function admin_print_scripts(){
		wp_print_scripts( array( 'sack' ));
		?>
			<script>
				function add_sidebar( sidebar_name )
				{
					
					var mysack = new sack("<?php echo admin_url( 'admin-ajax.php' ); ?>" );    
				
				  	mysack.execute = 1;
				  	mysack.method = 'POST';
				  	mysack.setVar( "action", "add_sidebar" );
				  	mysack.setVar( "sidebar_name", sidebar_name );
				  	mysack.encVar( "cookie", document.cookie, false );
				  	mysack.onError = function() { alert('Ajax error. Cannot add sidebar' )};
				  	mysack.runAJAX();
					return true;
				}
				
				function remove_sidebar( sidebar_name,num )
				{
					
					var mysack = new sack("<?php echo admin_url( 'admin-ajax.php' ); ?>" );    
				
				  	mysack.execute = 1;
				  	mysack.method = 'POST';
				  	mysack.setVar( "action", "remove_sidebar" );
				  	mysack.setVar( "sidebar_name", sidebar_name );
				  	mysack.setVar( "row_number", num );
				  	mysack.encVar( "cookie", document.cookie, false );
				  	mysack.onError = function() { alert('Ajax error. Cannot remove sidebar' )};
				  	mysack.runAJAX();
					//alert('hi!:::'+sidebar_name);
					return true;
				}
			</script>
		<?php
	}
	
	/**
	 * Add sidebar
	 *
	 * This function creates a new sidebar
	 *
	 * @since 	1.0
	 */
	static function add_sidebar(){
		$sidebars = sidebar_generator::get_sidebars();
		$name = trim( str_replace(array("\n","\r","\t"),'',$_POST['sidebar_name']) );
		$id = sidebar_generator::name_to_class($name);
		
		if(isset($sidebars[$id])){
			die("alert('Sidebar already exists, please use a different name.')");
		}
		if($name == 'null'){
			die();
		}
		elseif($name == ''){
			die("alert('Please specify a name for this sidebar.')");
		}
		
		$sidebars[$id] = $name;
		sidebar_generator::update_sidebars($sidebars);
		
		$js = "
			var tbl = document.getElementById('sbg_table');
			var lastRow = tbl.rows.length;
			// if there's no header row in the table, then iteration = lastRow + 1
			var iteration = lastRow;
			var row = tbl.insertRow(lastRow);
			
			// left cell
			var cellLeft = row.insertCell(0);
			var textNode = document.createTextNode('$name');
			cellLeft.appendChild(textNode);
      		cellLeft.setAttribute('style', 'padding-top: 10px; padding-bottom: 10px; font-weight: 700;background:#FFE4E8;');
			
			//middle cell
			var cellLeft = row.insertCell(1);
			var textNode = document.createTextNode('sb-$id');
			cellLeft.appendChild(textNode);            
      		cellLeft.setAttribute('style', 'padding-top: 10px; padding-bottom: 10px;background:#FFE4E8;');
						
			//last cell

			var rowc = document.getElementById('sbg_table').rows.length;
			rowc = parseInt(rowc-1);
			
			var cellLeft = row.insertCell(2);
			removeLink = document.createElement('a');
      		linkText = document.createTextNode('remove');
			removeLink.setAttribute('onclick', 'return remove_sidebar_link(\'$name\','+rowc+');return false;');
			removeLink.setAttribute('href', 'javascript:void(0)');
			removeLink.setAttribute('style', 'font-weight: 700; color: #2EA2CC');
        
      		removeLink.appendChild(linkText);
      		cellLeft.appendChild(removeLink);
			
      		cellLeft.setAttribute('style', 'padding-top: 10px; padding-bottom: 10px;background:#FFE4E8;');
		";
		
		
		die( "$js");
	}
	
	static function remove_sidebar(){
		$sidebars = sidebar_generator::get_sidebars();
		$name = str_replace(array("\n","\r","\t"),'',$_POST['sidebar_name']);
		$id = sidebar_generator::name_to_class($name);
		if(!isset($sidebars[$id])){
			die("alert('Sidebar does not exist.')");
		}
		$row_number = $_POST['row_number'];
		unset($sidebars[$id]);
		sidebar_generator::update_sidebars($sidebars);
		$js = "
			var tbl = document.getElementById('sbg_table');
			tbl.deleteRow($row_number)

		";
		die($js);
	}

	static function admin_menu(){
		add_submenu_page('themes.php', 'Sidebars', 'Sidebars', 'manage_options', __CLASS__, array('sidebar_generator','admin_page'));
	}

	static function admin_page(){
		?>
		<script>
			function remove_sidebar_link(name,num){
				answer = confirm("Are you sure you want to remove " + name + "?\nThis will remove any widgets you have assigned to this sidebar.");
				if(answer){
					//alert('AJAX REMOVE');
					remove_sidebar(name,num);
				}else{
					return false;
				}
			}
			function add_sidebar_link(){
				var sidebar_name = prompt("Sidebar Name:","");
				//alert(sidebar_name);
				add_sidebar(sidebar_name);
			}
		</script>
		<div class="wrap">
			<h2>Custom Sidebars Generator</h2>
            <br />
			<div class="add_sidebar">
				<a href="javascript:void(0);" onclick="return add_sidebar_link()" class="button-primary" title="Add a sidebar">Add New Sidebar</a>
			</div>
			<br />
			<table class="widefat page" id="sbg_table" style="width:100%;">
				<tr>
					<th>NAME</th>
					<th>CSS CLASS</th>
					<th>REMOVE</th>
				</tr>
				<?php
				$sidebars = sidebar_generator::get_sidebars();
				//$sidebars = array('bob','john','mike','asdf');
				if(is_array($sidebars) && !empty($sidebars)){
					$cnt=0;
					foreach($sidebars as $sidebar){
						$alt = ($cnt%2 == 0 ? 'alternate' : '');
				?>
				<tr class="<?php echo $alt?>">
					<td style="padding-top: 10px; padding-bottom: 10px;font-weight: 700;"><?php echo $sidebar; ?></td>
					<td>sb-<?php echo sidebar_generator::name_to_class($sidebar); ?></td>
					<td style="padding-top: 10px; padding-bottom: 10px;"><a href="javascript:void(0);" onclick="return remove_sidebar_link('<?php echo $sidebar; ?>',<?php echo $cnt+1; ?>);" style="font-weight: 700; color: #2EA2CC" title="Remove this sidebar">remove</a></td>
				</tr>
				<?php
						$cnt++;
					}
				}else{
					?>
					<tr>
						<td colspan="3">No Sidebars defined</td>
					</tr>
					<?php
				}
				?>
			</table>
			<br />
		</div>
		<?php
	}
    
	/**
	 * replaces array of sidebar names
	*/
	static function update_sidebars($sidebar_array){
		$sidebars = update_option('sbg_sidebars',$sidebar_array);
	}	
    
	/**
	 * gets the generated sidebars
	*/
	static function get_sidebars(){
		$sidebars = get_option('sbg_sidebars');
		return $sidebars;
	}

	static function name_to_class($name){
		$class = str_replace(array(' ',',','.','"',"'",'/',"\\",'+','=',')','(','*','&','^','%','$','#','@','!','~','`','<','>','?','[',']','{','}','|',':',),'',$name);
		return $class;
	}
	
}

$sbg = new sidebar_generator;
?>
