<?php
	if(empty($_GET['isPlane'])){
?>
<!-- SIDEBAR --> 
	<div id="sidebar">
		<ul>
			<?php
				$menuStr = '';
				
				/* To Get Module ID */
				$tmp = array_flip($aConfig['module']);
				$moduleId = $tmp[strtolower(MODULENAME)];
				
				foreach( $aConfig['menu-module'] as $k => $menu ){
					
					$menuCss = 'nosubmenu';
					$subMenu = '';
					
					if( !empty( $menu['sub-menu'] ) ){
						$menuCss = '';
						$subMenu = '<ul>';
												
						foreach( $menu['sub-menu'] as $kk => $sub_menu ){
							$subMenuClass = '';
							
							if( isset( $_GET['s-menu'] ) ){
								if( (strtolower($_GET['s-menu']) == strtolower($sub_menu['name'])) ){ $subMenuClass = 'current'; }
							}else if( $sub_menu['moduleId'] == $moduleId ){ $menuCss = 'current'; $subMenuClass = 'current'; }
							
							if( $sub_menu['moduleId'] == $moduleId ){ $menuCss = 'current'; }
							
							if ($this->user->hasPrivilege(strtolower($aConfig['module'][$sub_menu['moduleId']])."_".strtolower($sub_menu['action']))) {//to check permissions
								$subMenu .= '<li class="'.$subMenuClass.'"><a href="'.SITEPATH.$sub_menu['url'].'" title="'.$sub_menu['name'].'" >'.$sub_menu['name'].'</a>';
								
								/* Sub Sub Menu Start */
								if( !empty( $sub_menu['sub-menu'] ) ){
									$subMenu .= '<ul>';
									
									foreach( $sub_menu['sub-menu'] as $kkk => $sub_sub_menu ){
										$subMenuClass = '';
										
										if( $sub_sub_menu['moduleId'] == $moduleId ){ $menuCss = 'current'; $subMenuClass = 'current'; }
																					
										if ($this->user->hasPrivilege(strtolower($aConfig['module'][$sub_sub_menu['moduleId']])."_".strtolower($sub_sub_menu['action']))) {//to check permissions
											$subMenu .= '<li class="'.$subMenuClass.'"><a href="'.SITEPATH.$sub_sub_menu['url'].'" title="'.$sub_sub_menu['name'].'" >'.$sub_sub_menu['name'].'</a></li>';
										}
									
									}
									$subMenu .= '</ul>';
								}
								/* Sub Sub Menu End */
								
								
								$subMenu .= '</li>';
							}	
						}
						
						$subMenu .= '</ul>';

					}
					
					$menuUrl = '#'; if($menu['url'] != ''){ $menuUrl = SITEPATH.$menu['url']; }
					
					$showMainMenuFlag = false;
					foreach( $menu['moduleIdArr'] as $chkModuleId ){
						if ($this->user->hasPrivilege(strtolower($aConfig['module'][$chkModuleId])."_".strtolower($menu['action']))) {
							$showMainMenuFlag = true;
						}
					}
					
					if( $showMainMenuFlag ) {//to check permissions
						$menuStr .= '<li class="'.$menuCss.'">
									<a href="'.$menuUrl.'" title="'.$menu['name'].'" ><img src="'.IMGPATH.'icons/menu/dashboard.png" alt="" />'.$menu['name'].'</a>
									'.$subMenu.'
								</li>';
					}			
				} /* Foreach */

				echo $menuStr;
			
			?>
			
		</ul>
	<div id='lhsPlayerPreview' class='MT10' style='margin-left:20px;'></div>
	</div>
	
<?php
}
?>	