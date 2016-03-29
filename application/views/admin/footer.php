        </div>
        <!-- /body -->
        <footer>
            <div class="fluid-container clearfix">
                <p>Copyright &copy; 2014 Tell The Boss, Inc. All Rights Reserved.</p>
                <ul>
                    <li>
                        <a href="#terms">Terms &amp; Conditions</a>
                    </li>
                    <li>
                        <a href="#privacy">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#contact">Contact Us</a>
                    </li>
                </ul>
            </div>
        </footer>
    </div>
    <!-- /wrap -->

	<script>  
		$(function () { 
			$(".tip").tooltip({ container: 'body'});

			$.fn.editableform.buttons = 
				'<button type="submit" class="btn btn-ttb btn-sm editable-submit"><i class="glyphicon glyphicon-ok"></i></button>' +
				'<button type="button" class="btn btn-default btn-sm editable-cancel"><i class="glyphicon glyphicon-remove"></i></button>';
		});  
	</script> 

</body>

</html>
