@extends('layouts.member.app')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-comment-alt text-primary mr-2"></i>Laporan Member
    </h1>

    <div>
        <a href="{{ url('member/my_reports') }}" class="btn btn-sm btn-info shadow-sm">
            <i class="fas fa-list fa-sm text-white-50"></i> Lihat Laporan Saya
        </a>
    </div>

</div>


<!-- Flash Messages -->

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">

    <i class="fas fa-check-circle mr-2"></i>
    {{ session('success') }}

    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>

</div>
@endif


@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">

    <i class="fas fa-exclamation-triangle mr-2"></i>
    {{ session('error') }}

    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>

</div>
@endif



<!-- Member Info -->

<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">
            <i class="fas fa-user mr-2"></i>Informasi Member
        </h6>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">
                <p><strong>Nama:</strong> {{ $user['name'] ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $user['email'] ?? 'N/A' }}</p>
            </div>

            <div class="col-md-6">

                <p><strong>Kode Member:</strong> {{ $member['member_code'] ?? 'N/A' }}</p>

                <p>
                    <strong>Status:</strong>

                    <span class="badge badge-{{ ($member['status'] ?? '') == 'Active' ? 'success' : 'secondary' }}">
                        {{ $member['status'] ?? 'Unknown' }}
                    </span>

                </p>

            </div>

        </div>

    </div>

</div>



<!-- Report Form -->

<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-edit mr-2"></i>Form Laporan
        </h6>
    </div>

    <div class="card-body">

        <div class="alert alert-info mb-4">

            <i class="fas fa-info-circle mr-2"></i>

            <strong>Informasi:</strong>
            Gunakan form ini untuk menyampaikan saran, keluhan, atau masukan terkait fasilitas dan pelayanan gym.
            Tim kami akan merespon laporan Anda dalam 1-2 hari kerja.

        </div>


        <form action="{{ url('member/submit_report') }}" method="POST" id="reportForm">

            @csrf


            {{-- Category & Priority --}}
            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">

                        <label class="font-weight-bold">
                            <i class="fas fa-tags mr-1"></i>Kategori Laporan <span class="text-danger">*</span>
                        </label>

                        <select class="form-control @error('category') is-invalid @enderror" name="category"
                            id="category" required>

                            <option value="">Pilih Kategori</option>

                            @foreach($categories as $key => $value)

                            <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>

                            @endforeach

                        </select>


                        @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>

                </div>


                <div class="col-md-6">

                    <div class="form-group">

                        <label class="font-weight-bold">
                            <i class="fas fa-exclamation-circle mr-1"></i>Prioritas
                        </label>

                        <select class="form-control" name="priority" id="priority">

                            <option value="Low" {{ old('priority')=='Low'?'selected':'' }}>Rendah</option>
                            <option value="Medium" {{ old('priority','Medium')=='Medium'?'selected':'' }}>Sedang
                            </option>
                            <option value="High" {{ old('priority')=='High'?'selected':'' }}>Tinggi</option>

                        </select>

                        <small class="form-text text-muted">
                            Pilih tingkat prioritas laporan Anda
                        </small>

                    </div>

                </div>

            </div>


            {{-- Subject --}}
            <div class="row">

                <div class="col-12">

                    <div class="form-group">

                        <label class="font-weight-bold">
                            <i class="fas fa-heading mr-1"></i>Subjek <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                            value="{{ old('subject') }}" placeholder="Ringkasan singkat laporan Anda" required>

                        @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>

                </div>

            </div>



            {{-- Description --}}
            <div class="row">

                <div class="col-12">

                    <div class="form-group">

                        <label class="font-weight-bold">
                            <i class="fas fa-align-left mr-1"></i>Deskripsi Lengkap <span class="text-danger">*</span>
                        </label>

                        <textarea name="description" id="description" rows="6"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Jelaskan secara detail laporan Anda..."
                            required>{{ old('description') }}</textarea>


                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror


                        <small class="form-text text-muted">
                            Semakin detail informasi yang Anda berikan, semakin mudah bagi kami membantu
                        </small>

                    </div>

                </div>

            </div>



            {{-- Button --}}
            <div class="row">

                <div class="col-12">

                    <div class="form-group mb-0">

                        <button type="submit" class="btn btn-primary btn-lg mr-3">
                            <i class="fas fa-paper-plane mr-2"></i>Kirim Laporan
                        </button>

                        <button type="reset" class="btn btn-secondary btn-lg mr-3">
                            <i class="fas fa-undo mr-2"></i>Reset Form
                        </button>

                        <a href="{{ url('member') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                        </a>

                    </div>

                </div>

            </div>


        </form>

    </div>

</div>