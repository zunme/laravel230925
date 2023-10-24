/*
* var r = new makecal(); var tt = await r.getHtml('#test');
*/
function makecal (){
	const handleDayClick = (current) => setdate(current);
	const returnToday = () => setdate(moment());
	const today = moment()
    let sonday ={}
    let calendarData=[];

	function generate(date) {
 		const startday = date;
		const startWeek = startday.clone().startOf('month').week();
		const endWeek = startday.clone().endOf('month').week() === 1 ? 53 : today.clone().endOf('month').week();
    		let calendar = [];
		var yearMonth = {
			year : startday.format('YYYY'),
			month : startday.format('MM'),
			calendar : []
		}
		for (let week = startWeek; week <= endWeek; week++) {
			calendar.push(
			Array(7)
		            .fill(0)
		            .map((n, i) => {
		              // 오늘 => 주어진 주의 시작 => n + i일 만큼 더해서 각 주의 '일'을 표기한다.
                    let current = startday
		                .clone()
		                .week(week)
		                .startOf('week')
		                .add(n + i, 'day');

		              // 오늘이 current와 같다면 우선 '선택'으로 두자
                    let isSelected = today.format('YYYYMMDD') === current.format('YYYYMMDD') ? 'selected' : '';

		              // 만약, 이번 달이 아닌 다른 달의 날짜라면 회색으로 표시하자
                    let isGrayed = current.format('MM') !== today.format('MM') ? 'grayed' : '';
                    let findevent = sonday[current.format('YYYYMMDD')] ?? false;
                    /*
                    return {
                        current:current,
                        isSelected : isSelected,
                        isGrayed : isGrayed,
                        findevent : findevent,
                        day : current.format('D')
                    }
                    */
return `<div className="box ${isSelected} ${isGrayed}" onClick="setCustomCal('${current.format('YYYY-MM-DD')}')">
    ${ findevent ? `<span class="calendar_event">SON</span>`: ``}
    <div className="text">${current.format('D')}</div>
</div>`
			  })
			)
			 //calendar.push(t	)
		}
		yearMonth.calendar = calendar
		return yearMonth;
	}
	const makeCalendars= async()=>{
        let calendars =[];
        var res = await axios.get('/api/common/sondays')

        for ( var item of res.data ){
            sonday[moment(item.date).format('YYYYMMDD') ] = true
        }

	}
    const fnData = ()=>{
		calendarData.push(generate( moment() ) )

		//calendarData.push(generate( moment().startOf('month').add(1, 'M') ) )
		//calendarData.push(generate( moment().startOf('month').add(2, 'M') ) )
		return calendarData
    }
    this.getData = ()=>{
        return fnData()
    }
    this.getHtml = async (target) => {
        if( Object.keys(sonday).length == 0 ) await makeCalendars()
        if(calendarData.length == 0 ) fnData()

        var html = ''
        for( var item of calendarData){
            html += `
            <div class="month_wrap">
                <div class="month_title">${item.year}-${item.month}</div>
                <div class="month_body">`
                item.calendar.map( (row, n)=>{
                    html += `<div class="month_week_row">`
                        row.map( (col )=>{
                            html += col
                        })
                    html += `</div>`
                })
            html +=`
                </div>
            </div>
            `
        }
        if( target ) $(target).html( html)
        return html
    }
}
const setCustomCal = (date)=>{console.log ( date )}
/*
* vertical news ticker
* Tadas Juozapaitis ( kasp3rito@gmail.com )
* http://plugins.jquery.com/project/vTicker
*/
(function(a){a.fn.vTicker=function(b){var c={speed:700,pause:4000,showItems:3,animation:"",mousePause:true,isPaused:false,direction:"up",height:0};var b=a.extend(c,b);moveUp=function(g,d,e){if(e.isPaused){return}var f=g.children("ul");var h=f.children("li:first").clone(true);if(e.height>0){d=f.children("li:first").height()}f.animate({top:"-="+d+"px"},e.speed,function(){a(this).children("li:first").remove();a(this).css("top","0px")});if(e.animation=="fade"){f.children("li:first").fadeOut(e.speed);if(e.height==0){f.children("li:eq("+e.showItems+")").hide().fadeIn(e.speed)}}h.appendTo(f)};moveDown=function(g,d,e){if(e.isPaused){return}var f=g.children("ul");var h=f.children("li:last").clone(true);if(e.height>0){d=f.children("li:first").height()}f.css("top","-"+d+"px").prepend(h);f.animate({top:0},e.speed,function(){a(this).children("li:last").remove()});if(e.animation=="fade"){if(e.height==0){f.children("li:eq("+e.showItems+")").fadeOut(e.speed)}f.children("li:first").hide().fadeIn(e.speed)}};return this.each(function(){var f=a(this);var e=0;f.css({overflow:"hidden",position:"relative"}).children("ul").css({position:"absolute",margin:0,padding:0}).children("li").css({margin:0,padding:0});if(b.height==0){f.children("ul").children("li").each(function(){if(a(this).height()>e){e=a(this).height()}});f.children("ul").children("li").each(function(){a(this).height(e)});f.height(e*b.showItems)}else{f.height(b.height)}var d=setInterval(function(){if(b.direction=="up"){moveUp(f,e,b)}else{moveDown(f,e,b)}},b.pause);if(b.mousePause){f.bind("mouseenter",function(){b.isPaused=true}).bind("mouseleave",function(){b.isPaused=false})}})}})(jQuery);

$(function(){  
	$('#dv_rolling').vTicker({   
		speed: 500,
		pause: 3000,
		animation: 'fade',  
		mousePause: true,  
		showItems: 20,
		height: 355,
		direction: 'up'
	});

}); 