<!--    CONTENT -->

<div id="content" style="margin: 0px 0px 0px 0px;color: #6D6D6D;padding: 0px 0px 0px;">
  <?php
		/* To show errorr */
		if( !empty($aError) ){
			$aParam = array(
						'type' => 'error',
						'msg' => $aError,
					 );
			TOOLS::showNotification( $aParam );
		}

		/* To show success */
		if( !empty($aSuccess) || ( isset($_GET['msg']) && $_GET['msg'] != '') ){
			if( isset($_GET['msg']) && $_GET['msg'] != '' ){ $aSuccess[] = cms::sanitizeVariable( $_GET['msg'] ); }
			$aParam = array(
						'type' => 'success',
						'msg' => $aSuccess,
					 );
			TOOLS::showNotification( $aParam );
		}

	?>
  <div class="bloc" style="margin: 0px 0px 0px 0px;">
 	 <?php
		$aParam = array(
							'cType'=>4,
							'relatedCType'=>0,
							'id'=>(int)$_GET['id'],
							'title' => $aContent[0]->title ." Deployments Details",
							'tab' => 'deployment',
						);
		echo TOOLS::displayViewTabsHtml( $aParam );
	?>
    <div class="content">
      <form id='actFrm' name='actFrm' method="POST" onsubmit="return checkCheckbox();">
        <table>
          <thead>
            <tr>
			  <th>Deployment</th>
			  <th>Deployment Name</th>
			  <th>Editor</th>
			  <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php
				if( !empty($aContent) ){
					foreach( $aContent as $showData){
			?>
            <tr>
			  <td><?php echo $showData->service_provider; ?></td>
			  <td><?php echo $showData->deployment_name; ?></td>
			  <td><?php echo $showData->name; ?></td>
			  <td><?php echo $showData->update_date; ?></td>
            </tr>
            <?php
					} /* foreach end */
				}else{
						echo '<tr>
								<td colspan=6>'.$aConfig['no-contents'].'</td>
							  </tr>';
					} /* If End */
				?>
          </tbody>
        </table>
        <br/>
      </form>
      <div class="pagination">
        <?php
			echo $sPaging;
		?>
      </div>
    </div>
  </div>
</div>
<!--  CONTENT End -->