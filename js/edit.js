$(document).ready( function (){

    $('[data-toggle="tooltip"]').tooltip();
	var actions = $("table td:last-child").html();

    //append table with add row form on add new button click
    $(".add-new").click(function(){
        $(this).attr("disabled", "disabled");
        var index = $("table tbody tr:last-child").index();
        var row = '<tr class="addQuestion">' +
            '<td class="count"><input type="text" class="form-control" name="question" id="question" placeholder="Enter question"></td>' +
            '<td class="count"><input type="text" class="form-control" name="option_a" id="option_a" placeholder="Enter option A"></td>' +
            '<td class="count"><input type="text" class="form-control" name="option_b" id="option_b" placeholder="Enter option B"></td>' +
            '<td class="count"><input type="text" class="form-control" name="option_c" id="option_c" placeholder="Enter option C"></td>' +
            '<td class="count"><select class="form-control" id="answer"><option disabled selected value>Select correct answer</option><option>A</option><option>B</option><option>C</option></select></td>' +
            '<td>' + actions + '</td>' +
        '</tr>';
        $("table").append(row);
        $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
        $('[data-toggle="tooltip"]').tooltip();
    });

    //add row on add button click
    $(document).on("click", ".add", function(){
		var empty = false;
		var input = $(this).parents("tr").find('input[type="text"]');
        input.each(function(){
			if(!$(this).val()){
				$(this).addClass("error");
				empty = true;
			} else{
                $(this).removeClass("error");
            }
		});
		$(this).parents("tr").find(".error").first().focus();
		if(!empty){
			input.each(function(){
				$(this).parent("td").html($(this).val());
			});			
			$(this).parents("tr").find(".add, .edit").toggle();
			$(".add-new").removeAttr("disabled");
        }
        var question_id = $(this).closest('tr').attr('id');
        if($(this).closest('tr').attr('id') != null){
            var updateData = new Array();
    
            $(this).closest('tr').each(function(row, tr){
                updateData[row]={
                    "question" : $(tr).find('td:eq(0)').text(), 
                    "option_1" :$(tr).find('td:eq(1)').text(), 
                    "option_2" : $(tr).find('td:eq(2)').text(), 
                    "option_3" : $(tr).find('td:eq(3)').text(), 
                    "answer" : $(tr).find('td:eq(4)').text()
                };
            }); 
        }else{
            return;
        }
        $.ajax({
            type: "POST",
            url: "/epa/php/edit.php",
            data: {
                "updateQuestion": "1",
                "updateData": updateData,
                "question_id" : question_id
            },
            dataType: 'JSON',
            success: function(response){
            }
        });
    });

    //edit row on edit button click
    $(document).on("click", ".edit", function(){		
        $(this).parents("tr").find("td:not(:last-child)").each(function(){
			$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
		});		
		$(this).parents("tr").find(".add, .edit").toggle();
        $(".add-new").attr("disabled", "disabled");
    });

    //delete row on delete button click
    $(document).on("click", ".delete", function(){
        $(this).parents("tr").remove();
        $(".add-new").removeAttr("disabled");
        if($(this).closest('tr').attr('id') != ''){
            var question_id = $(this).closest('tr').attr('id');
            $.ajax({
                type: "POST",
                url: "/epa/php/edit.php",
                data: {
                    "deleteQuestion": "1",
                     "question_id" : question_id
                },
                dataType: 'JSON',
                success: function(response){
                }
            });
        }
    });

    $(document).on("click", "#saveQuiz", function(event){
        var param = {};
        param.title = $("#quiz_title").val();
        param.username = $("#username").val();
        event.preventDefault();
        var myData = [],
            keys = ['question','option_a','option_b','option_c','answer'],
            url = this.action;
            $('table').find('tr:gt(0)').each(function(i, row) {
                var oRow = {};
                $(row).find('td.count').each( function(j, cell) {
                   oRow[keys[j]] = $(cell).text();
                });
                myData.push(oRow);
                console.log(myData);
             });
            $.ajax({
                type: "POST",
                url: "/epa/php/edit.php",
                data: {
                    "saveData": "1",
                    "param": param,
                    "myData": myData
                },
                dataType: 'JSON',
                success: function(response){
                    window.location.href = "index.php";
                }
            });
    });

} );