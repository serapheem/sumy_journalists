function displayClock() 
{
    var date_obj = new Date();
    
    var Year = '' + date_obj.getFullYear();
    
    var Month = '' + (date_obj.getMonth() + 1);
    Month = (Month.length < 2) ? ('0' + Month) : Month;
    
    var Day = '' + date_obj.getDate();
    Day = (Day.length < 2) ? ('0' + Day) : Day;
    
    var Hours = '' + date_obj.getHours();
    Hours = (Hours.length < 2) ? ('0' + Hours) : Hours;
    
    var Minutes = '' + date_obj.getMinutes();
    Minutes = (Minutes.length < 2) ? ('0' + Minutes) : Minutes;
    
    var clock = '<div>' + Day + '.' + Month + '.' + Year + '</div>' +
                '<div><img src="/themes/classic/images/clock.png" title="clock"/><span>' +
                Hours + ':' + Minutes + '</span></div>';
    
    document
        .getElementById('clock')
        .innerHTML=clock;
    
    var half_minute = 30000;
    setTimeout(displayClock, half_minute);
}
jQuery(document).ready(function() 
{
    displayClock();
});
function ratingChange(id, model, term) 
{
    $.getJSON('/ajax/rating', 
    		{
    			'id': id,
    			'model': model,
    			'term': term
    		},
		    function(data) 
		    {
		        if ( !data['error'] ) 
		        {
		            $("#rating-down, #rating-up, #current-rating").fadeOut(300, function() 
		            {
		                $('#current-rating').html( data['rating'] ).addClass('no-change');
		                
		                if (data['rating'] > 0) 
		                {
		                    $('#current-rating').removeClass('negative').addClass('positive')
		                } 
		                else if (data['rating'] < 0) 
		                {
		                    $('#current-rating').removeClass('positive').addClass('negative')
		                } 
		                else if (data['rating'] == 0) 
		                {
		                    $('#current-rating').removeClass('negative').removeClass('positive')
		                }
		                
		                $('#current-rating').fadeIn(300)
		            })
		        }
		        else {
		        	alert( data['msg'] )
		        }
		    }
		)
}
function addParticipantVote(id, model) 
{
	$("#rating-" + id).find('.ajax-loader, .ajax-overlay').show();
    $.getJSON('/ajax/rating', 
    		{
    			'id': id,
    			'model': model,
    			'term': 1
    		},
		    function(data) 
		    {
		        if ( !data['error'] ) 
		        {
		        	$("#rating-" + id).fadeOut(300, function() 
		            {
		            	$("#rating-" + id).text( 'Голосів: ' + data['rating'] ).fadeIn(300)
		            })
		        }
		        else {
		        	alert( data['msg'] );
		        	$("#rating-" + id).find('.ajax-loader, .ajax-overlay').hide()
		        }
		    }
		)
}
function addVote() 
{
    var poll_id = $('#poll input[name=poll_id]').val();
    var item_id = $('#poll input[name="vote"]:checked').val(); 
    
    $.getJSON('/ajax/addvoite', 
    		{
    			'poll_id': poll_id, 
    			'item_id': item_id
    		}, 
    		function(data) 
		    {
		        if ( !data['error'] ) 
		        {
		            $("#poll").fadeOut(500, function() 
		            {
		                $(this).html(data['html']);
		                $(this).fadeIn(500)
		            })
		        }
		    }
		)
}