<div>
    <style>
        .hover-menu-box:hover{
            border: 2px solid blue;
        }
    </style>
    <h3>MY MENU</h3>
    <button class="btn btn-setup float-right" data-toggle="modal"
            data-target="#configMenu">   {{__('common.config.setting')}} </button>
    <div wire:ignore.self class="modal fade" id="configMenu" tabindex="-1" aria-labelledby="exampleModal"
         aria-hidden="true">
        <div class="modal-dialog" style="padding: 10px;    max-width: 654px;">
            <form class="modal-content" action="{{route('update-menu')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-header"
                     style=" padding-left: 0 !important; ;  border-bottom: 1px solid white !important;margin: auto;">
                    <div>
                        <h3 style="font-size: 26px;
    color: black;">{{__('menu.menu-title')}}</h3>
                    </div>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title">{{__('common.config.select-feature')}}</h5>
                    <div class="overflow-scroll-y  h-400">
                        @foreach($menu as $key => $page)
                            @if(checkPermission($page->alias))
                                @if(array_search($page->alias,\App\Enums\EMenu::listNameMenu()) == false)
                                    <div class="checkbox-config hover-menu-box" >
                                        {{--                                    @foreach(\App\Enums\EMenu::listNameMenu() as $routeName)--}}
                                        {{--                                        @if($routeName === $page->alias)--}}
                                        {{--                                            --}}
                                        {{--                                        @endif--}}
                                        {{--                                        123--}}
                                        {{--                                    @endforeach--}}
                                        <input type="checkbox" id="checkbox{{$key}}" name="checkedMenu[{{$page->id}}]"
                                               value="{{$page->id}}" {{ $page->isChecked ?'checked' :''}}>
                                        <label for="checkbox{{$key}}"><span> {{\App\Enums\EMenu::listNameMenu()[$page->alias] ?? '...'}}</span></label>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="group-btn2 text-center pt-24" style="    border-top: 1px solid white;">
                    <button type="button" id="cancel" class="btn btn-cancel" data-dismiss="modal" wire:click="render" >
                        {{__('common.config.delete')}}
                    </button>
                    <button type="submit"

                            class="btn btn-save">  {{__('common.config.save')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#configMenu').on('hidden.bs.modal', function () {
        $('input:checkbox').removeAttr('checked');
    });
</script>

