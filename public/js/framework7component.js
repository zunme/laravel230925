const store = Framework7.createStore({
    state: {
        token:null,
        flash :null,
    },
    actions:{
        //store.dispatch('flash',{flash: {'ooo':'fff'} })
        flash({state, dispatch}, {flash} ){
            state.flash = flash
        },
        clear({state}){
            state.flash =null
        },
    },
    getters: {
        flash:({state, dispatch})=>{
            return state.flash
        },
    }
});

Framework7.registerComponent(
    'my-search-inputs',
    (props, { $h }) => {
        var wrap_class = "list-strong-ios list-dividers-ios inset-ios";
        var data = ( props.hasOwnProperty('data') ) ? props.data : {};
        
        //string => object 데이터로 변경
        //ex (string)"key1.key2" => value of object.key1.key2
        const multiIndex=(obj,is)=>{  // obj,['1','2','3'] -> ((obj['1'])['2'])['3']
            return is.length ? multiIndex(obj[is[0]],is.slice(1)) : obj
        }
        const pathIndex=(is)=> {   // obj,'1.2.3' -> multiIndex(obj,['1','2','3'])
            return multiIndex(data,is.split('.')) ?? ''
        }
        
        return () => $h`
<div class="tw-flex tw-justify-end tw-gap-2">
    ${props.list.map( item =>$h`
        ${item.type=='hidden' ? $h`
            <input type="hidden" 
                value="${ data[item.name] ?? ''}" 
                name="${item.name}" />
        `:''}
        ${item.type=='text' || item.type=='password' || item.type=='number' ? $h`
            <div class="relative">
                ${item.label ? $h`
                    <div class="floating-label absolute tw-text-xs">${item.label}</div>
                `:''}
                <!-- class : tw-input-search -->
                <input class="tw-cal tw-bg-gray-300/50 tw-border tw-border-gray-300 
                    tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-min-w-[200px] tw-px-[10px]
                    tw-py-[6px]" 
                    type="${item.type}"
                    placeholder="${item.placeholder ?? ''}"
                    name="${item.name}" />
            </div>
        `:''}
        
        ${item.type=='select' ? $h`
            <div class="relative">
                ${item.label ? $h`
                    <div class="floating-label absolute tw-text-xs">${item.label}</div>
                `:''}
                <select class="tw-flex tw-justify-between tw-select tw-bg-gray-300/50 tw-border tw-border-gray-300 
                            tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-min-w-[140px] tw-px-[10px] tw-py-[6px]"
                    name="${item.name}"
                    >
                    ${item.options.map(opt=>$h`
                        <option value="${opt.val ?? ''}" selected=${opt.val== pathIndex(item.name) } >${opt.label ?? '선택해주세요'}</option>
                    `)}
                </select>
            </div>
        `:''}
        ${item.type=='date' || item.type=='datetime' ? $h`
            <div class="relative">
                ${item.label ? $h`
                    <div class="floating-label absolute tw-text-xs">${item.label}</div>
                `:''}
                <input class="tw-cal tw-bg-gray-300/50 tw-border tw-border-gray-300 
                        tw-text-gray-900 tw-text-sm tw-rounded-lg tw-block tw-min-w-[140px]
                        tw-px-[10px] tw-py-[6px]"
                    type="${item.type}" 
                    name="${item.name}" 
                    placeholder="${item.placeholder ?? ''}"/>
            </div>
        `:''}
    `)}
</div>
        `
    }
)

Framework7.registerComponent(
 /*
     .. 옵션 object 를 array 로
     .. Object.entries( objectdata ) :: object=> array;
    
    .. 사용법
     .. click을 사용한다면 click 용 function 우선 선언
    const openDaum = (e)=>{
        openDaumPostPop('auto_contract')
    }
    
    let inputSet = [
        {'type':'hidden', 'name':'id'},
        {'type':'text', 'name':'contract.contract_address1','label':'계약 주소1',hidemedia:true,'readonly':true},
        {'type':'text', 'name':'contract_zip','label':'우편번호','disabled':false,'readonly':true, 'required':true, 'icon':{'ico':null, 'class':''}},
        {'type':'text', 'name':'contract.contract_address','label':'계약 주소','disabled':false,'readonly':true, 'required':false,hidemedia:true, 'click':openDaum, 'click_name':'변경' },
        {'type':'select', 'name':'confirmed','label':'상태', 'required':true, 'icon':{'ico':null, 'class':''}
            ,'options':[
                {val:'confirmed', label:'승인'},
                {val:'denied', label:'거부'},
                {val:'ready' , label:'승인대기'},
            ], 그외 class 지정가능
        },
    ];
    ${data ? $h`
        <my-input-lists data=${data} list=${inputSet}></my-input-lists>
    `:''}
*/
    'my-input-lists',
    (props, { $h }) => {
        var wrap_class = "list-strong-ios list-dividers-ios inset-ios";
        var data = ( props.hasOwnProperty('data') ) ? props.data : {};
        
        //string => object 데이터로 변경
        //ex (string)"key1.key2" => value of object.key1.key2
        const multiIndex=(obj,is)=>{  // obj,['1','2','3'] -> ((obj['1'])['2'])['3']
            return is.length ? multiIndex(obj[is[0]],is.slice(1)) : obj
        }
        const pathIndex=(is)=> {   // obj,'1.2.3' -> multiIndex(obj,['1','2','3'])
            return multiIndex(data,is.split('.')) ?? ''
        }
        
        return () => $h`
<div class="list ">
    <ul>
    ${props.list.map( item =>$h`
        ${item.type=='hidden' ? $h`
            <input type="hidden" 
                value="${ data[item.name] ?? ''}" 
                name="${item.name}" />
        `:''}
        ${item.type=='text' || item.type=='password' || item.type=='number' || item.type=='file' ? $h`
            <li class="item-content item-input item-input-outline ${item.class_li ?? ''}">
                ${item.hidemedia ? '':$h`
                <div class="item-media">
                    ${ !item.hasOwnProperty('icon') ? $h`
                    <i class="fa-solid fa-square tw-text-xl tw-text-stone-500"></i>
                    `:$h`
                        ${ !item.icon.ico ? $h`
                            ${ (item.readonly || item.disabled) ? $h`
                                <i class="fa-solid fa-square-xmark tw-text-xl tw-text-stone-500 ${item.icon.class??''}"></i>
                            `:$h`
                                ${ (item.required) ? $h`
                                    <i class="fa-solid fa-square tw-text-xl tw-text-sky-800 ${item.icon.class??''}"></i>
                                `:$h`
                                    <i class="fa-solid fa-square tw-text-xl tw-text-sky-300 ${item.icon.class??''}"></i>
                                `}
                            `}
                        `:$h`
                            ${item.icon.ico}
                        `}
                    `}
                </div>
                `}
                <div class="item-inner ${item.class_item_innder ?? ''}">
                    <div class="item-title item-label">${item.label ?? ''}</div>
                    <div class="item-input-wrap ${ item.click ? $h`tw-flex tw-items-center`:''} ${item.class_input_wrap ?? ''} ${item.type=='file' ? 'tw-flex tw-item-center':''} ">
                        ${item.type=='file' ? $h`
                            <input type="file" placeholder="${item.holder??''}" class="${item.class_input ?? ''}" 
                                name="${item.name}" 
                                readonly=${item.readonly==true} 
                                required=${item.required==true} 
                                disabled=${item.disabled==true} 
                            />
                            ${ data[item.name] ? $h`
                            <a class="link external button button-fill color-green tw-text-white button-small tw-w-[100px]" href="${ data[item.name] ?? ''}" target="_blank">보기</a>
                            `:''}
                        `:$h`
                            <input type="${item.type}" placeholder="${item.holder??''}" class="${item.class_input ?? ''}" 
                                value="${ pathIndex(item.name) ?? ''}" 
                                name="${item.name}" 
                                readonly=${item.readonly==true} 
                                required=${item.required==true} 
                                disabled=${item.disabled==true} 
                            />
                            ${item.click ? $h`
                                <button type="button" class="button button-fill color-red button-small tw-w-auto"  @click=${item.click} >${item.click_name ?? '확인'}</button>
                            `:$h`
                                <span class="input-clear-button"></span>
                            `}
                        `}
                    </div>
                </div>
            </li>
        `:''}
        
        ${item.type=='select' ? $h`
            <li class="item-content item-input item-input-outline ${item.class_li ?? ''}">
                ${item.hidemedia ? '':$h`
                <div class="item-media">
                    ${ !item.hasOwnProperty('icon') ? $h`
                    <i class="fa-solid fa-square tw-text-xl tw-text-stone-500"></i>
                    `:$h`
                        ${ !item.icon.ico ? $h`
                            ${ (item.readonly || item.disabled) ? $h`
                                <i class="fa-solid fa-square-xmark tw-text-xl tw-text-stone-500 ${item.icon.class??''}"></i>
                            `:$h`
                                ${ (item.required) ? $h`
                                    <i class="fa-solid fa-square tw-text-xl tw-text-sky-800 ${item.icon.class??''}"></i>
                                `:$h`
                                    <i class="fa-solid fa-square tw-text-xl tw-text-sky-300 ${item.icon.class??''}"></i>
                                `}
                            `}
                        `:$h`
                            ${item.icon.ico}
                        `}
                    `}
                </div>
                `}
                <div class="item-inner ${item.class_item_innder ?? ''}">
                    <div class="item-title item-label">${item.label ?? ''}</div>
                    <div class="item-input-wrap input-dropdown-wrap ${item.class_input_wrap ?? ''}">
                        <select class="input-with-value ${item.class_input ?? ''}"
                            name="${item.name}"
                            readonly=${item.readonly==true} 
                            required=${item.required==true} 
                            disabled=${item.disabled==true} 
                        >
                            ${item.options.map(opt=>$h`
                                <option value="${opt.val ?? ''}" selected=${opt.val== pathIndex(item.name) } >${opt.label ?? '선택해주세요'}</option>
                            `)}
                        </select>
                                
                    </div>
                </div>
            </li>
        `:''}
        ${item.type=='date' || item.type=='datetime' ? $h`
            <li class="item-content item-input item-input-outline ${item.class_li ?? ''}">
                ${item.hidemedia ? '':$h`
                <div class="item-media">
                    ${ !item.hasOwnProperty('icon') ? $h`
                    <i class="fa-solid fa-square tw-text-xl tw-text-stone-500"></i>
                    `:$h`
                        ${ !item.icon.ico ? $h`
                            ${ (item.readonly || item.disabled) ? $h`
                                <i class="fa-solid fa-square-xmark tw-text-xl tw-text-stone-500 ${item.icon.class??''}"></i>
                            `:$h`
                                ${ (item.required) ? $h`
                                    <i class="fa-solid fa-square tw-text-xl tw-text-sky-800 ${item.icon.class??''}"></i>
                                `:$h`
                                    <i class="fa-solid fa-square tw-text-xl tw-text-sky-300 ${item.icon.class??''}"></i>
                                `}
                            `}
                        `:$h`
                            ${item.icon.ico}
                        `}
                    `}
                </div>
                `}
                <div class="item-inner ${item.class_item_innder ?? ''}">
                    <div class="item-title item-label">${item.label ?? ''}</div>
                    <div class="item-input-wrap ${ item.click ? $h`tw-flex`:''} ${item.class_input_wrap ?? ''} ">
                        <input type="${item.type=='date' ? 'date' : 'datetime-local'}" placeholder="${item.holder??''}" class="${item.class_input ?? ''}" 
                                value="${ item.type=='date' ? (pathIndex(item.name) ? moment(pathIndex(item.name)).format('Y-MM-DD'):'') :   ( pathIndex(item.name) ? moment(pathIndex(item.name)).format('Y-MM-DD HH:mm:ss') :'') }" 
                                name="${item.name}" 
                                readonly=${item.readonly==true} 
                                required=${item.required==true} 
                                disabled=${item.disabled==true} 
                        />
                        ${item.click ? $h`
                            <button type="button" class="button button-fill color-red button-small tw-w-auto"  @click=${item.click} >${item.click_name ?? '확인'}</button>
                        `:$h`
                            <span class="input-clear-button"></span>
                        `}
                    </div>
                </div>
            </li>
        `:''}
        ${item.type=='textarea' ? $h`
            <li class="item-content item-input item-input-outline ${item.class_li ?? ''}">
                ${item.hidemedia ? '':$h`
                <div class="item-media">
                    ${ !item.hasOwnProperty('icon') ? $h`
                    <i class="fa-solid fa-square tw-text-xl tw-text-stone-500"></i>
                    `:$h`
                        ${ !item.icon.ico ? $h`
                            ${ (item.readonly || item.disabled) ? $h`
                                <i class="fa-solid fa-square-xmark tw-text-xl tw-text-stone-500 ${item.icon.class??''}"></i>
                            `:$h`
                                ${ (item.required) ? $h`
                                    <i class="fa-solid fa-square tw-text-xl tw-text-sky-800 ${item.icon.class??''}"></i>
                                `:$h`
                                    <i class="fa-solid fa-square tw-text-xl tw-text-sky-300 ${item.icon.class??''}"></i>
                                `}
                            `}
                        `:$h`
                            ${item.icon.ico}
                        `}
                    `}
                </div>
                `}
                <div class="item-inner ${item.class_item_innder ?? ''}">
                    <div class="item-title item-label">${item.label ?? ''}</div>
                    <div class="item-input-wrap tw-p-[10px] ${ item.click ? $h`tw-flex`:''} ${item.class_input_wrap ?? ''} ${item.type=='file' ? 'tw-flex tw-item-center':''} ">
                        <textarea name="" name="${item.name}">${ data[item.name] ?? ''}</textarea>
                    </div>
                </div>
            </li>
        `:''}
    `)}
    </ul>
</div>
        `
    }
);

Framework7.registerComponent(
// component name
'draw-star',

// component function
(props, { $h }) => {
  var pointsprop = props.points
  var classname = (typeof props.classname =='string' ? props.classname:'')
  var points = 0;
  if( typeof pointsprop== 'string'){
    points = parseFloat(pointsprop)
    if( isNaN(points) ) points = 0
  }else if ( typeof pointsprop== 'number'){
    points = pointsprop;
  } else {
    points = (typeof pointsprop=='object' && typeof pointsprop.star_total !='undefined') ? pointsprop.star_total : 0;
  }
  let retstr = ''
  for(var i =1; i <=5;i++){
    points = points - 1
    if( points >= 0 ) retstr += `<i class="fa-solid fa-star full_score"></i>`
    else if( points >= -0.5 ) retstr += `<i class="fa-regular fa-star-half-stroke harf_score"></i>`
    else retstr += `<i class="fa-regular fa-star none_score"></i>`
  }
  return () => $h`<div class="${classname}" innerHTML=${retstr}></div>`;
}
)
 /*
 <star-point addclass="tw-flex" inputname="star_point_inp" valuedisplay="left"></star-point>
 */
Framework7.registerComponent(
'star-point',
(props, { $update,$onMounted, $h }) => {
    let _starpoint = 0;
    let _stars = []
    const starpoint = (e)=>{
        const nodes = [...e.target.parentElement.children];
        const index = nodes.indexOf(e.target);
          _starpoint = index;
        $update()
    }
    $onMounted(() => {
        console.log ( props )
        var starlen = ( typeof props.starlen =='undefined') ? 5 : parseInt(props.starlen);
        _stars = Array.from(Array(starlen))
        $update()
    })
    return()=>$h`
    <div class="stars-rating ${props.hasOwnProperty('addclass') ? props.addclass : '' }" @click=${starpoint}>
    
     ${props.hasOwnProperty('valuedisplay') && props.valuedisplay =='left' ? $h`
        <div class="stars-rating-before">
            ${_starpoint}
        </div>
    `:''}
        <div class="stars-rating-inner">
            <input type="hidden" value="${_starpoint}" name="${props.hasOwnProperty('inputname') ? props.inputname : 'starpoints' }" />
            ${_stars.map( (item, index)=>$h`
                ${index  < _starpoint ? $h`
                    <i class="star-point-solid fa-star fa-solid"></i>
                `:$h`
                    <i class="star-point-regular fa-star fa-regular"></i>
                `}

            `)}
        </div>
        ${props.hasOwnProperty('valuedisplay') && props.valuedisplay =='right' ? $h`
        <div class="stars-rating-after">
            ${_starpoint}
        </div>
        `:''}
    </div>
    `
}
)
Framework7.registerComponent(
'draw-star-empty',
(props, { $h }) => {
  var classname = (typeof props.classname =='string' ? props.classname:'')
  return () => $h`
  <div class="${classname}">
    <i class="fa-regular fa-star none_score"></i>
    <i class="fa-regular fa-star none_score"></i>
    <i class="fa-regular fa-star none_score"></i>
    <i class="fa-regular fa-star none_score"></i>
    <i class="fa-regular fa-star none_score"></i>
  </div>
  `;
}
)