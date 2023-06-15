<div class="col-md-3 col-12">
    <form id="filter_form" action="{{ route('search') }}">
        <input type="hidden" name="search" value="{{  request()->search }}">
        <input type="hidden" name="starts_at" value="{{ request()->starts_at }}">
        <input type="hidden" name="ends_at" value="{{ request()->ends_at }}">
        <div class="filters-box rounded bg-white shadow-sm border mb-4">
            <div class="filter-item">
                <div class="title p-2">
                    <h6 class="fw-bold m-0 p-0 py-1"> الترتيب </h6>
                </div>
                <div class="filter-content p-2">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="sort" id="sort" checked value="" />
                        <label class="form-check-label" for="sort"> الكل </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="sort" id="price1" value="lowest_price"/>
                        <label class="form-check-label" for="price1"> الأرخص سعرا </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="sort" id="price2" value="highest_price"/>
                        <label class="form-check-label" for="price2"> الأغلى سعرا </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="sort" id="rating" value="highest_rating"/>
                        <label class="form-check-label" for="rating"> الأعلى تقييما </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sort" id="views" value="most_views"/>
                        <label class="form-check-label" for="views"> الأكثر مشاهدة </label>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="filters-box rounded bg-white shadow-sm border">
            <div class="filter-item">
                <div class="title p-2">
                    <h6 class="fw-bold m-0 p-0 py-1"> التصفية </h6>
                </div>
                <div class="filter-title">
                    <h6 class="fw-bold p-2" style="background-color: #f2f2f2;"> حسب الفئة </h6>
                </div>
                <div class="filter-content p-2">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="type" id="type" value="" checked />
                        <label class="form-check-label" for="flexRadioDefault1"> الكل </label>
                    </div>
                    @foreach ($types as $value => $type)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="type" id="type{{ $value }}" value="{{ $value }}" />
                        <label class="form-check-label" for="type{{ $value }}"> {{ $type }} </label>
                    </div>
                    @endforeach
                </div>
                <div class="filter-title">
                    <h6 class="fw-bold p-2" style="background-color: #f2f2f2;"> حسب العنوان </h6>
                </div>
                <div class="filter-content p-2">
                    <div class="form-check mb-2">
                        <select class="form-control mb-2 text-end" name="governorate_id">
                            <option value="">كل المحافظات</option>
                            @foreach ($governorates as $id => $governorate)
                            <option value="{{ $id }}" @if (request()->governorate_id == $id) selected @endif> {{ $governorate }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check mb-2">
                        <select class="form-control mb-2 text-end" name="region_id">
                            <option value="">كل المناطق</option>
                            @foreach ($regions as $id => $region)
                            <option value="{{ $id }}"> {{ $region }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="filter-title">
                    <h6 class="fw-bold p-2" style="background-color: #f2f2f2;"> حسب التقييم </h6>
                </div>
                <div class="filter-content p-2">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="rate" id="prrateice" value="" checked />
                        <label class="form-check-label text-muted" for="prrateice">الكل</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="rate" id="prrateice4" value="4" />
                        <label class="form-check-label text-warning" for="prrateice4"> <i class="fas fa-star"></i> <i
                                class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                class="fas fa-plus text-muted"></i></label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="rate" id="prrateice3" value="3" />
                        <label class="form-check-label text-warning" for="prrateice3"> <i class="fas fa-star"></i> <i
                                class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                class="fas fa-plus text-muted"></i></label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="rate" id="prrateice2" value="2" />
                        <label class="form-check-label text-warning" for="prrateice2"> <i class="fas fa-star"></i> <i
                                class="fas fa-star"></i> <i class="fas fa-plus text-muted"></i></label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="rate" id="prrateice1" value="1" />
                        <label class="form-check-label text-warning" for="prrateice1"> <i class="fas fa-star"></i> <i
                                class="fas fa-plus text-muted"></i></label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>