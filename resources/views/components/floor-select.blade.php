<div class="relative" x-data="{
    open:false,
    floor_sel :'',
    floor_title:'{{$holder}}',
    togglePop(){
        this.open = !this.open
    },
}" 
x-init="$watch('floor_sel', (value) => {
    floor_title = value == -1 ? '지하 1층' : `${value}층`
    togglePop()
})"
>
<input type="hidden" name="{{$name}}_floor" x-model="floor_sel" />
<input type="text"
    class="tw-pr-[80px]" style="background: #edeff5 url(/img/arrow_blue.png) 97% /27px no-repeat !important;" 
    name="{{$name}}_floor_title" placeholder="{{$holder}}" readonly="" x-model="floor_title"
    :class="{'placeholder': floor_sel=='' }"
    @click="togglePop()"
    >
    <template x-teleport="body">
        <div class="popup floor" :class="{ 'active':open }">
            <div class="content">
                <button class="popup__close_new" @click="togglePop()">
                    <img src="./img/popup_close.png" alt="close">
                </button>
                <h2>층수 선택</h2>
                <form>
                    <div class="floor__list scrollDesign tw-p-1">
                        @foreach( config('moveinfo.floor') as $floor )
                            <label>
                                <input type="radio" class="tw-hidden" x-model="floor_sel" 
                                    name="floor_sel" value="{{$floor['val']}}" />
                                <div>
                                    {{$floor['label']}}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </form>
            </div>
            <div class="bg"></div>
        </div>
    </template>
</div>