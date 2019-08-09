jQuery(document).ready(function ($) {
	

	
    var JOB_FILE_UPLOAD = {
        init:function () {

            this.attach();
            
        },
        attach:function () {
				
				

            if (job_file_uploader.upload_enabled !== '1') {
                return
            }

            var uploader = new plupload.Uploader(job_file_uploader.plupload);

            $('#file-uploader').click(function (e) {
				
				
                uploader.start();
				
                // To prevent default behavior of a tag
                e.preventDefault();
            });

            //initilize  wp plupload
            uploader.init();



            uploader.bind('FilesAdded', function (up, files) {


                $.each(files, function (i, file) {
					
					if(file)
						{
							$('#file-upload-container .loading').css('display','block');
							$('#file-upload-container .loading').html(file.name+', Size: '+plupload.formatSize(file.size));
						}
					
					
							
                });

               
			   
                uploader.start();
            });


            // On erro occur
            uploader.bind('Error', function (up, err) {
				
				$('#file-upload-container .loading').html('Error: '+err.code+', Message: '+err.message+'File:'+err.file.name);
				$('#file-upload-container .loading').fadeIn();

                
            });

            uploader.bind('FileUploaded', function (up, file, response) {
                var result = $.parseJSON(response.response);

                if (result.success) {
					$('#file-upload-container .loading').fadeOut();
					
                    $('#uploaded-image-container').prepend(result.html);
					
                   var img_src = $('#uploaded-image-container img').attr('src');					
                   $('#file_job_bm_company_logo').val(img_src);
                }
            });


        },

       


    };

    JOB_FILE_UPLOAD.init();
});