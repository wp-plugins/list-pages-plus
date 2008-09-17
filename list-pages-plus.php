<?php
/*
Plugin Name: List Pages Plus
Plugin URI: http://skullbit.com/wordpress-plugin/list-pages-plus/
Description: Alter the output of the wp_list_pages() function
Author: Skullbit.com
Version: 1.0
*/
load_plugin_textdomain( 'lpplus', '/wp-content/plugins/list-pages-plus' );
if( !class_exists( 'ListPagesPlus' ) ):
	class ListPagesPlus {
		function ListPagesPlus(){
			add_filter( 'wp_list_pages', array($this, 'ApplyEnhancements') );
			add_action( 'admin_menu', array($this, 'AddPanel') );
			if( $_POST['action'] == 'lpplus_update' )
				add_action( 'init', array($this,'SaveSettings') );
		}
		
		function AddPanel(){
			add_options_page( __('List Pages Plus', 'lpplus'), __('List Pages Plus', 'lpplus'), 10, 'list-pages-plus', array($this, 'Panel'));
		}
		
		function SaveSettings(){
			check_admin_referer('lpplus-update-options');
			$update = get_option( 'list_pages_plus' );
			$update['sort_column'] = $_POST['sort_column'];
			$update['sort_order'] = $_POST['sort_order'];
			$update['exclude'] = $_POST['exclude'];
			$update['depth'] = $_POST['depth'];
			$update["class"] = $_POST['class'];
			$update["title_li"] = $_POST['title_li'];
			$update["pre"] = $_POST['pre'];
			$update["post"] = $_POST['post'];
			$update["subclass"] = $_POST['subclass'];
			$update["subtitle"] = $_POST['subtitle'];
			$update["subpre"] = $_POST['subpre'];
			$update["subpost"] = $_POST['subpost'];
			update_option( 'list_pages_plus', $update );
			$_POST['notice'] = __('Settings Saved', 'lpplus');
		}
		
		function Panel(){
			$enhanced = get_option('list_pages_plus');
			$sort_column = $enhanced['sort_column'];
			$sort_order = $enhanced['sort_order'];
			$exclude = $enhanced['exclude'];
			$depth = $enhanced['depth'];
			$title_li = $enhanced['title_li'];
			$ac = $enhanced['class'];
			$at = $enhanced['title'];
			$pre = $enhanced['pre'];
			$post = $enhanced['post'];
			$sac = $enhanced['subclass'];
			$sat = $enhanced['subtitle'];
			$spre = $enhanced['subpre'];
			$spost = $enhanced['subpost'];
			if( $_POST['notice'] )
				echo '<div id="message" class="updated fade"><p><strong>' . $_POST['notice'] . '.</strong></p></div>';
			?>
            <div class="wrap">
            	<h2><?php _e('List Pages Plus', 'lpplus');?></h2>
                <p><?php _e('Enhance your Page List menu by making additions to the default classes, title, and tags surrounding the Page Title for both Parent and Child pages.', 'lpplus');?></p>
             <form method="post" action=""> 
             <?php if( function_exists( 'wp_nonce_field' )) wp_nonce_field( 'lpplus-update-options'); ?>
             	<p><code>&lt;li class="&hellip;<input type="text" name="class" value="<?php echo $ac;?>" style="width:50px;font-size:0.8em;" />">&lt;a href="&hellip;" title="<?php _e('Page Title', 'lpplus');?><input type="text" name="title" value="<?php echo $at;?>" style="width:50px;font-size:0.8em;" />"><input type="text" name="pre" value="<?php echo $pre;?>" style="width:50px;font-size:0.8em;" /><?php _e('Parent Page Title', 'lpplus');?><input type="text" name="post" value="<?php echo $post;?>" style="width:50px;font-size:0.8em;" />&lt;/a>&lt;/li></code></p>
                <p><code>&lt;li class="&hellip;<input type="text" name="subclass" value="<?php echo $sac;?>" style="width:50px;font-size:0.8em;" />">&lt;a href="&hellip;" title="<?php _e('Page Title', 'lpplus');?><input type="text" name="subtitle" value="<?php echo $sat;?>" style="width:50px;font-size:0.8em;" />"><input type="text" name="subpre" value="<?php echo $spre;?>" style="width:50px;font-size:0.8em;" /><?php _e('Child Page Title', 'lpplus');?><input type="text" name="subpost" value="<?php echo $spost;?>" style="width:50px;font-size:0.8em;" />&lt;/a>&lt;/li></code></p>
                <h3><?php _e('Override Arguments', 'lpplus');?></h3>
                <p><?php _e('You can replace your <code>wp_list_pages();</code> function with <code>wp_list_pages_plus();</code> and set the default arguments here.  You can also override these arguments using the same inline arguments as', 'lpplus');?> <a href="http://codex.wordpress.org/Template_Tags/wp_list_pages">wp_list_pages()</a> <?php _e('in your template files', 'lpplus');?>.
                <table class="form-table"> 
                	<tr> 
                		<th scope="row"><label for="title_li"><?php _e('Title', 'lpplus');?></label></th> 
                		<td><input type="text" name="title_li" id="title_li" value="<?php echo $title_li;?>" /></td> 
                	</tr> 
                    <tr> 
                		<th scope="row"><label for="sort_column"><?php _e('Sort Column', 'lpplus');?></label></th> 
                		<td><?php $this->SelectList( array('post_title', 'menu_order', 'post_date', 'post_modified', 'ID', 'post_author', 'post_name'), 'sort_column', $sort_column);?></td> 
                	</tr> 
                    <tr> 
                		<th scope="row"><label for="sort_order"><?php _e('Sort Order', 'lpplus');?></label></th> 
                		<td><?php $this->SelectList( array('asc', 'desc'), 'sort_order', $sort_order);?></td> 
                	</tr> 
                    <tr> 
                		<th scope="row"><label for="exclude"><?php _e('Exclude', 'lpplus');?></label></th> 
                		<td><?php $this->SelectPage( 'exclude', $exclude);?></td> 
                	</tr> 
                   
                    <tr> 
                		<th scope="row"><label for="depth"><?php _e('Depth', 'lpplus');?></label></th> 
                		<td><?php $this->SelectList( array('0|Pages & sub-pages displayerd in a hierarchical (indented) form', '-1|Pages & sub-pages displayed in flat (no indent) form', '1|Show only top level Pages', '2|Decend to 2nd level of Pages only', '3|Decend to 3rd level of Pages only'), 'depth', $include);?></td> 
                	</tr> 
                 </table>
             
                
                <p class="submit"><input type="submit" value="<?php _e('Save Settings', 'lpplus');?>" /></p>
                <input name="action" value="lpplus_update" type="hidden" />
             </form> 
            </div>
            <?php
		}
		
		function SelectPage( $id, $select=false ){
			global $wpdb;
			$pages = $wpdb->get_results( "SELECT ID, post_title FROM $wpdb->posts WHERE post_type='page' ORDER BY menu_order, post_title ASC" );
			$out = "<select name='$id' id='$id' multiple='multiple' size='8' style='height:160px;'>\n";
			if( !is_array($select) ) $select = array($select);
			foreach( $pages as $pg ):
				$out .= "\t<option value='".$pg->ID."'";
				if( in_array($pg->ID, $select) ) $out .= " selected='selected'";
				$out .= ">".$pg->post_title."</option>\n";
			endforeach;
			$out .= "</select>";
			echo $out;
		}
		
		function SelectList( $array, $id, $select=false ){
			$out = "<select name='$id' id='$id'>\n";
			foreach( $array as $opt ):
				$op = explode( '|', $opt);
				$opt = $op[0];
				if( $op[1] ) $nm = $op[1]; else $nm = $op[0];
				$out .= "\t<option value='$opt'";
				if( $opt == $select ) $out .= " selected='selected'";
				$out .= ">$nm</option>\n";
			endforeach;
			$out .= "</select>";
			echo $out;
		}
		
		function ApplyEnhancements($pages){
			$enhanced = get_option('list_pages_plus');
			$ac = ' '.$enhanced['class'];
			$at = $enhanced['title'];
			$pre = $enhanced['pre'];
			$post = $enhanced['post'];
			$sac = ' '.$enhanced['subclass'];
			$sat = $enhanced['subtitle'];
			$spre = $enhanced['subpre'];
			$spost = $enhanced['subpost'];
			
			//put each li in an array
			$litem = explode('</li>', $pages);
			
			//print_r($litem);
			
			foreach( $litem as $k=>$li ):
				//check for ul and seperate
				if( strpos( $li, '<ul>' ) ):
					$lis = explode( '<ul>', $li );
					$class1 = $this->GetValue( 'class="', '"', $lis[0] );
					$href1 = $this->GetValue( 'href="', '"', $lis[0] );
					$title1 = $this->GetValue( 'title="', '"', $lis[0] );
					$text1 = $this->GetValue( $title1.'">', '</a>', $lis[0] );
					$class2 = $this->GetValue( 'class="', '"', $lis[1] );
					$href2 = $this->GetValue( 'href="', '"', $lis[1] );
					$title2 = $this->GetValue( 'title="', '"', $lis[1] );
					$text2 = $this->GetValue( $title2.'">', '</a>', $lis[1] );
					
					$litem[$k] = "\n\t" . '<li class="'.$class1.$ac.'"><a href="'.$href1.'" title="'.$title1.$at.'">'.$pre.$text1.$post.'</a>'. "\n\t <ul> \n\t" .'<li class="'.$class2.$sac.'"><a href="'.$href2.$sah.'" title="'.$title2.$sat.'">'.$spre.$text2.$spost.'</a>';
					$issub = 1;
				elseif( strpos( $li, '</ul>' ) ):
					$issub = false;
				elseif( strpos( $li, 'li') ):
					$class = $this->GetValue( 'class="', '"', $li );
					$href = $this->GetValue( 'href="', '"', $li );
					$title = $this->GetValue( 'title="', '"', $li );
					$text = $this->GetValue( $title.'">', '</a>', $li );
					
					
					//put back together
					
					if( $issub ):		
						$litem[$k] = "\n\t" . '<li class="'.$class.$sac.'"><a href="'.$href.'" title="'.$title.$sat.'">'.$spre.$text.$spost.'</a>'.$end;
					else:
						$litem[$k] = "\n\t" . '<li class="'.$class.$ac.'"><a href="'.$href.'" title="'.$title.$at.'">'.$pre.$text.$post.'</a>';
					endif;
					
					
				endif;
				
			endforeach;
			
			$pages = implode('</li>', $litem);
			
			return $pages;
		}
		
		function GetValue($start, $end, $item){
			$output = explode( $start, $item );
			$output = explode( $end, $output[1]);
			$output = $output[0];
			return $output;
		}
	}
endif;

if( class_exists( 'ListPagesPlus' ) )
	$lpe = new ListPagesPlus();
	
function wp_list_pages_plus($args=''){
	global $lpe;
	$enhanced = get_option('list_pages_plus');
 
	$defaults = array(
		'depth' => $enhanced['depth'], 'show_date' => '',
		'date_format' => get_option('date_format'),
		'child_of' => 0, 'exclude' => $enhanced['exclude'],
		'title_li' => $enhanced['title_li'], 'echo' => 1,
		'authors' => '', 'sort_column' => $enhanced['sort_column'], 
		'sort_order' => $enhanced['sort_order']
	);
	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );
	
	if( $r['include'] )
		$include = '&include='.$r['include'];
	
	if( $r['echo'] == 1 )
		wp_list_pages('title_li='.$r['title_li'].'&sort_column='.$r['sort_column'].'&sort_order='.$r['sort_order'].'&exclude='.$r['exclude'].'&include='.$r['include'].'&depth='.$r['depth'].'&echo='.$r['echo'].'&show_date='.$r['show_date'].'&date_format='.$r['date_format'].'&authors='.$r['authors'].$include);	
	else 
		return wp_list_pages('title_li='.$r['title_li'].'&sort_column='.$r['sort_column'].'&sort_order='.$r['sort_order'].'&exclude='.$r['exclude'].'&depth='.$r['depth'].'&echo='.$r['echo'].'&show_date='.$r['show_date'].'&date_format='.$r['date_format'].'&authors='.$r['authors'].$include);
}
?>
