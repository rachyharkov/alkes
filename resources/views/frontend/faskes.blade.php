@extends('layouts.master-frontend')
@section('title', 'List Faskes')
@section('content')
    <div class="page-content-wrapper">
        <div class="py-3">
            <div class="container">
                <div class="row g-1 align-items-center rtl-flex-d-row-r">
                    <div class="col-4">
                        <div class="select-product-catagory" style="width: 100%">
                            <select class=" small border-0" id="selectProductCatagory" name="kategori"
                                aria-label="Default select example">
                                <option value="all">All Jenis Faskes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="select-product-catagory">
                            <select class=" small border-0" id="selectProductCatagory" name="label"
                                aria-label="Default select example">
                                <option value="all">All Kabkot</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="select-product-catagory">
                            <select class=" small border-0" id="selectProductCatagory" name="short"
                                aria-label="Default select example">
                                <option value="" disabled selected>Short By</option>
                                <option value="" disabled>Nama A-Z</option>
                                <option value="" disabled>Nama Z-A</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3"></div>
                <div class="row g-2">
                    {{-- mulai --}}
                    @foreach ($faskesdata as $faskesdata)
                        <div class="col-12" style="background-color: #FFF;  border-radius:5px">
                            <div class="horizontal-product-card">
                                <div class="d-flex align-items-center">
                                    <div class="product-thumbnail-side">
                                        <a class="product-thumbnail shadow-sm d-block" href="#"><img
                                                src="{{ asset('frontend/img/hospital2.png') }}" alt=""
                                                style="width: 80%"></a>
                                    </div>
                                    <div class="product-description">
                                        <a class="product-title d-block" href="#">{{ $faskesdata->nama_faskes }}</a>
                                        <p class="sale-price"><i class="fa fa-tag" aria-hidden="true"></i>
                                            Jenis Faskes : {{ $faskesdata->nama_jenis_faskes }}</p>
                                        <div class="product-rating"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                            {{ $faskesdata->kabupaten_kota }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
