                    <!-- 3개월 달력 -->
                    <div x-data="{
                        open : false,
                        calendars : [],
                        today : moment(),
                        sonday : {},
                        selected_day : null,
                        selected_day_format : null,
                        getselected (){
                        return this.selected_day ? this.selected_day.format('YYYY-MM-DD') : ''
                        },
                        getSon(){
                        axios.get('/api/common/sondays').then( res => {
                            var temp=[]
                            for ( var item of res.data ){
                            temp[moment(item.date).format('YYYYMMDD') ] = true
                            }
                            this.sonday = temp;
                            this.makeData()
                        })
                        },
                        generate(date) {
                        const startday = date;
                        const startWeek = startday.clone().startOf('month').week();
                        const endWeek = startday.clone().endOf('month').week() === 1 ? 53 : startday.clone().endOf('month').week();
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
                                let isSelected = this.today.format('YYYYMMDD') === current.format('YYYYMMDD') ? 'today' : '';
                
                            // 만약, 이번 달이 아닌 다른 달의 날짜라면 회색으로 표시하자
                                //let isGrayed = current.format('MM') !== this.today.format('MM') ? 'ui-state-disabled' : '';
                                let isGrayed = current < this.today ? 'ui-state-disabled' : '';
                
                                let findevent = this.sonday[current.format('YYYYMMDD')] ?? false;
                                return {
                                    current:current,
                                    isSelected : isSelected,
                                    isGrayed : isGrayed,
                                    findevent : findevent,
                                    day : current.format('D')
                                }
                            })
                            )
                        }
                        yearMonth.calendar = calendar
                            this.calendars.push( yearMonth )
                        },
                        makeData(){
                            this.generate( moment() )
                            this.generate( moment().startOf('month').add(1, 'M') ) 
                            this.generate( moment().startOf('month').add(2, 'M') )
                        },
                        togglePop(){
                            this.open = !this.open
                        },
                        setDate(d){
                            if( d.isGrayed !='') return;
                            this.selected_day = d.current
                            this.selected_day_format = d.current.format('YYYY-MM-DD')
                            this.open = false
                        },
                        init(){
                            this.getSon();
                            this.$watch('open', () => {
                                if( this.open ) document.querySelector('body').classList.add('tw-overflow-hidden')
                                else document.querySelector('body').classList.remove('tw-overflow-hidden')
                            })
                        }
                    }">
                    <div class="relative">
                        <input type="text" @click="togglePop()" x-model="selected_day_format" 
                            class="tw-pr-[80px]"
                            style="background: #edeff5 url(/img/arrow_blue.png) 97% /27px no-repeat !important;" 
                            name="{{$calendar_name}}"
                            placeholder="{{$calendar_holder}}" readonly/>
                    </div>
                    <template x-teleport="body">
                        <div class="popup tw-border-init calendar" :class="{ 'active':open }">
                            <div class="content">
                            
                                <button class="popup__close_new"  @click="togglePop()">
                                    <img src="./img/popup_close.png" alt="close">
                                </button>
                                <h2>이사 날짜를 선택해주세요.</h2>

                            <div class="datepicker2424_outer scrollDesign tw-mb-[50px]">
                                <div class="calendar-container">
                                    <template x-for="cal in calendars">
                                        <div  class="calendar calendar-month-wrap tw-font-[20px]">
                                            <h2 x-text="`${cal.year}년 ${cal.month}월`"></h2>
                                            <div class="calendar-month-body">
                                                <div class="tw-border-b tw-border-gray-400 tw-border-t tw-grid tw-grid-cols-7 tw-h-[52px] tw-items-center tw-mb-6 tw-mt-4">
                                                    <div class="tw-text-[20px] text-center">일</div>
                                                    <div class="tw-text-[20px] text-center">월</div>
                                                    <div class="tw-text-[20px] text-center">화</div>
                                                    <div class="tw-text-[20px] text-center">수</div>
                                                    <div class="tw-text-[20px] text-center">목</div>
                                                    <div class="tw-text-[20px] text-center">금</div>
                                                    <div class="tw-text-[20px] text-center">토</div>
                                                </div>
                                            <template x-for="row in cal.calendar">
                                                <div class="calendar-row tw-grid tw-grid-cols-7">
                                                <template x-for="col in row">
                                                    <div class="calendar-day relative tw-flex tw-h-[38px] tw-justify-center tw-items-center"  x-bind:class="[col.current == selected_day ? 'selected':'' , col.isSelected ?? '', col.isGrayed ?? '']" @click="setDate(col)">
                                                        <div class="absolute" x-bind:class="[col.findevent ? 'son':'not-son']"></div>
                                                        <div class="calendar-day-text"x-text="col.day"></div>
                                                    </div>
                                                </template>
                                                </div>
                                            </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="infobox">
                                <span class="redot"></span>
                                <span>손 없는 날/금-토요일은 가격이 비쌀수 있어요.</span>
                            </div>

                            </div>  
                            <div class="bg_new" @click="togglePop()">
                        </div>
                    </template>
                </div>
                <!-- / -->