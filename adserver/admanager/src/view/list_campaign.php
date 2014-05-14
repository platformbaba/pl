<h1><img src="img/icons/posts.png" alt="" />&nbsp</h1>

<a href="<?php echo SITEPATH ;?>campaign?action=edit" class="button">Add New</a>


<div class="bloc">
    <div class="title">
        Campaigns list
    </div>
<div class="content">
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" class="checkall"/></th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>St Date</th>
                    <th>End Date</th>
                    <th>Priority</th>
                    <th><img src="img/th-comment.png" alt="" /></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            	<?php 
            	if($messenger['data']['cmp_list']){
            		foreach($messenger['data']['cmp_list'] as $cmp){
						extract($cmp);
            			echo "<tr>
			                    <td><input type='checkbox' /></td>
			                    <td><a href='".SITEPATH."campaign?action=edit&id=$cmp_id'>$cmp_id</a></td>
			                    <td><a href='".SITEPATH."campaign?action=edit&id=$cmp_id'>$cmp_name</td>
			                    <td>$cmp_start_date</td>
			                    <td>$cmp_end_date</td>
			                    <td>$cmp_priority</td>
			                    <td>&nbsp</td>
			                    <td class='actions'>
			                    	<span title='Edit this content'>$cmp_status</span>
			                    	<a href='".SITEPATH."campaign?action=editc&id=$cmp_id' title='Constraints'><img src='img/icons/edit.png' alt='' /> EditC</a>
      								<a href='".SITEPATH."campaign?action=editam&id=$cmp_id' title='Constraints'><img src='img/icons/edit.png' alt='' /> EditAdMapping</a>
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