
<h1><img src="img/icons/posts.png" alt="" />&nbsp</h1>

<a href="<?php echo SITEPATH ;?>ad?action=edit" class="button">Add New</a>


<div class="bloc">
    <div class="title">
        Ads list
    </div>
<div class="content">
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" class="checkall"/></th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Ad Type</th>
                    <th>Dimension</th>
                    <th>Campaign</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th><img src="img/th-comment.png" alt="" /></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            	<?php 
            	if(isset($messenger['data']['ad_list'])){
            		foreach($messenger['data']['ad_list'] as $ad){
						extract($ad);
            			echo "<tr>
			                    <td><input type='checkbox' /></td>
			                    <td><a href='".SITEPATH."ad?action=edit&id=$ad_id'>$ad_id</a></td>
			                    <td><a href='".SITEPATH."ad?action=edit&id=$ad_id'>$ad_name</td>
			                    <td>$ad_type</td>
			                    <td>$dim_name</td>
			                    <td>$cmp_name</td>
			                    <td>$start_date</td>
			                    <td>$end_date</td>
			                    <td>&nbsp</td>
			                    <td class='actions'>
			                    <span title='Edit this content'>$ad_status</span>
			                  </tr>";
            		}
            	}
                 
                ?>
             </tbody>
        </table>
       <!--  <div class="left input">
            <select name="action" id="tableaction">
                <option value="">Action</option>
                <option value="delete">Delete</option>
            </select>
        </div> -->
       <!--  <div class="pagination">
            <a href="#" class="prev">«</a>
            <a href="#">1</a>
            <a href="#" class="current">2</a>
            ...
            <a href="#">21</a>
            <a href="#">22</a>
            <a href="#" class="next">»</a>
        </div> -->
    </div>
</div>