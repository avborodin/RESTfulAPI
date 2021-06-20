$(document).ready(function () {
    ajax(1);
    $( "#logout" ).click(function(){
         $.ajax({
            type: "DELETE",
            url: "api/auth.php",
            cache: false,
            success: function (data) {
                if(data.txt == 'Success'){
                    window.location.href = "login.html";
                }
                //console.log(data.txt);
            }
        });
     });
});

function get_data_student(page){
    ajax(page);
}

function ajax(page){
    $.ajax({
        url: "api/users.php",
        data: {page:page},
        cache: false,
        success: function (data) {
            
            if (data.error) {
                window.location.href = "login.html";
                return;
            }
            
            var users = data.records;
            var user_html = '';
            for (var i in users) {
                user_html += '<div class="row user-row">';
                user_html += '  <div class="col">';
                user_html += '      <div>';
                user_html +=        users[i].username+'<br>'+users[i].first_name+' '+users[i].last_name;
                user_html += '      </div>';
                user_html += '  </div>';
                user_html += '  <div class="col">';
                user_html += '      <div>';
                user_html += '      ...<br>'+users[i].group_name;
                user_html += '      </div>';
                user_html += '  </div>';
                user_html += '</div>';
            }
            $("#user-list").html(user_html);
            
            var pagination_html = "";
            var pages_html = '';

            for (var i in data.paging['pages']){
                pages_html += '<a href="javascript:void(0);" class="user-page-item '+data.paging['pages'][i].current_page+'" onclick="get_data_student('+data.paging['pages'][i].page+');">'+data.paging['pages'][i].page+'</a>';
            }
            if(data.paging['first']){
                pagination_html += '<a href="javascript:void(0);" class="user-page-item" onclick="get_data_student('+data.paging['first']+');"><< Previous</a>';
            }
            pagination_html += pages_html;
            if(data.paging['last']){
                pagination_html += '<a href="javascript:void(0);" class="user-page-item" onclick="get_data_student('+data.paging['last']+');">Next >></a>';
            }
               
            $("#user-pagination").html(pagination_html);
        }
    });
}