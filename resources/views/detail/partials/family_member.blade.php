<li>
    <a href="#" data-bs-toggle="modal" data-bs-target="#MemberModal{{ $member->id }}" title="{{ $member->nama }}"
        style="position: relative; display: inline-block;">
        <!-- Top-left position -->
        <small style="
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: {{ $member->jenis_kelamin == 'Laki-Laki' ? '#3b82f6' : '#ec4899' }};
            color: white;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 9999px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            font-size: 0.75rem;
            line-height: 1;
            min-width: 24px;
            text-align: center;
            z-index: 100;
        ">{{ $member->urutan }}
        </small>

        <!-- Top-right position -->
        @if ($member->partners->count() > 0)
            <small
                style="position: absolute;top: -10px;right: -10px;background: white; color: white; font-weight: bold; border-radius: 9999px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); font-size: 0.75rem; line-height: 1; min-width: 24px; text-align: center; z-index: 100;">
                <i class='bx bxs-heart-circle bx-sm' style='color:#ff0095'></i>
            </small>
        @endif

        <div class="d-flex" style="position: relative;">
            @if ($member->jenis_kelamin == 'Laki-Laki')
                <img src="{{ asset('assets/img/avatars/laki.jpg') }}" alt="Foto Default Laki-laki" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;
                                            @if ($member->status_kehidupan == 'Wafat') filter: grayscale(100%); @endif">
            @elseif ($member->jenis_kelamin == 'Perempuan')
                <img src="{{ asset('assets/img/avatars/perempuan.jpg') }}" alt="Foto Default Perempuan" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;
                                            @if ($member->status_kehidupan == 'Wafat') filter: grayscale(100%); @endif">
            @endif
        </div>

        <span class="capitalize"
            style="display: inline-block; max-width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $member->nama }}</span>
    </a>

    <!-- Jika anggota memiliki anak, tampilkan daftar anak -->
    @if ($member->children->count() > 0)
        <ul>
            @foreach ($member->children->sortBy('urutan') as $child)
                @include('detail.partials.family_member', ['member' => $child])
            @endforeach
        </ul>
    @endif

    <div class="modal fade" id="MemberModal{{ $member->id }}" tabindex="-1" aria-labelledby="memberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="height: 600px;">
                <div class="modal-body text-center pb-4 d-flex flex-column" style="height: 100%;">
                    @if ($member->jenis_kelamin == 'Laki-Laki')
                        <img src="{{ asset('assets/img/avatars/laki.jpg') }}" alt="Foto Default Laki-laki"
                            class="rounded-circle position-absolute top-0 start-50 translate-middle"
                            style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;
                                                    @if ($member->status_kehidupan == 'Wafat') filter: grayscale(100%); @endif">
                    @elseif ($member->jenis_kelamin == 'Perempuan')
                        <img src="{{ asset('assets/img/avatars/perempuan.jpg') }}" alt="Foto Default Perempuan"
                            class="rounded-circle position-absolute top-0 start-50 translate-middle"
                            style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;
                                                    @if ($member->status_kehidupan == 'Wafat') filter: grayscale(100%); @endif">
                    @endif
                    <div class="mt-10">
                        {{ $member->nama }}
                    </div>
                    <div class="nav nav-tabs nav-justified mt-5 mb-3" role="tablist">
                        <div class="nav-item" role="presentation">
                            <button class="nav-link active" id="bio-tab" data-bs-toggle="tab"
                                data-bs-target="#bio-{{ $member->id }}" type="button" role="tab" aria-controls="bio"
                                aria-selected="true">
                                Biodata
                            </button>
                        </div>
                        <div class="nav-item" role="presentation">
                            <button class="nav-link" id="family-tab" data-bs-toggle="tab"
                                data-bs-target="#family-{{ $member->id }}" type="button" role="tab"
                                aria-controls="family" aria-selected="false">
                                Pasangan
                            </button>
                        </div>
                        <div class="nav-item" role="presentation">
                            <button class="nav-link" id="notes-tab" data-bs-toggle="tab"
                                data-bs-target="#notes-{{ $member->id }}" type="button" role="tab" aria-controls="notes"
                                aria-selected="false">
                                Anak
                            </button>
                        </div>
                    </div>
                    <div class="tab-content text-start p-2 flex-grow-1" style="overflow-y: scroll; overflow-x: hidden;">
                        <div class="tab-pane fade show active" id="bio-{{ $member->id }}" role="tabpanel"
                            aria-labelledby="bio-tab">
                            <div class="row g-4">
                                <div class="col mb-4">
                                    <label for="nama_anggota_keluarga" class="form-label">Nama</label>
                                    <div class="form-control bg-primary-hover">{{ $member->nama }}</div>
                                </div>
                                <div class="col mb-4">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <div class="form-control bg-primary-hover">
                                        {{ $member->tanggal_lahir ? \Carbon\Carbon::parse($member->tanggal_lahir)->format('d-m-Y') : 'Belum diketahui' }}
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4 mb-4">
                                @if ($member->parent)
                                    <div class="col">
                                        <label for="nama_anggota_keluarga" class="form-label">Orang Tua 1</label>
                                        <div class="form-control bg-primary-hover"
                                            style="cursor: pointer; border: 1px solid #ced4da; padding: 0.375rem 0.75rem;"
                                            data-bs-toggle="modal" data-bs-target="#MemberModal{{ $member->parent->id }}">
                                            {{ $member->parent->nama }}
                                        </div>
                                    </div>
                                @endif
                                @if ($member->parent)
                                    <div class="col">
                                        <label for="nama_anggota_keluarga" class="form-label">Orang Tua 2</label>
                                        <div class="form-control bg-primary-hover"
                                            style="cursor: pointer; border: 1px solid #ced4da; padding: 0.375rem 0.75rem;"
                                            @if ($member->parent_partner_id) data-bs-toggle="modal"
                                            data-bs-target="#PartnerModal{{ $member->parent_partner_id }}" @endif>
                                            @if ($member->parent_partner_id && $member->parent2)
                                                {{ $member->parent2->nama }}
                                            @elseif ($member->parent_partner_id)
                                                Pasangan tidak ditemukan
                                            @else
                                                Belum diketahui
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row g-4">
                                <div class="col mb-4">
                                    <label for="nama_anggota_keluarga" class="form-label">Anak Ke</label>
                                    <div class="form-control bg-primary-hover">{{ $member->urutan }}</div>
                                </div>
                            </div>
                            @if ($member->alamat)
                                <div class="row g-4">
                                    <div class="col mb-4">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" name="alamat"
                                            readonly>{{ $member->alamat }}</textarea>
                                    </div>
                                </div>
                            @endif
                            <div class="row g-4">
                                @if ($member->photo)
                                    <div class="col">
                                        <label for="nama_anggota_keluarga" class="form-label">Kontak</label>
                                        <div class="form-control bg-primary-hover d-flex align-items-center justify-content-between"
                                            style="cursor: pointer; border: 1px solid #ced4da; padding: 0.5rem 1rem;"
                                            onclick="window.open('{{ $member->photo }}', '_blank')">
                                            <span>Buka Foto</span>
                                            <i class="bx bx-link-external" style="font-size: 1.1rem;"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="tab-pane fade" id="family-{{ $member->id }}" role="tabpanel"
                            aria-labelledby="family-tab">
                            <div class="mb-3">
                                @if ($member->partners->count() > 0)
                                    <h6 class="d-flex align-items-center mb-3">
                                        <i class="bi bi-heart me-2"></i>Pasangan
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Nama</th>
                                                    <th class="text-center">Tanggal Lahir</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($member->partners as $partner)
                                                    <tr>
                                                        <td class="text-center align-middle">{{ $partner->nama }}</td>
                                                        <td class="text-center align-middle">
                                                            {{ $partner->tanggal_lahir ? \Carbon\Carbon::parse($partner->tanggal_lahir)->translatedFormat('d F Y') : 'Belum diketahui' }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#PartnerModal{{ $partner->id }}">
                                                                <i class="bi bi-eye"></i> Lihat
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-center text-muted py-3">
                                        <i class="bi bi-info-circle me-2"></i>Data pasangan belum ditambahkan
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="tab-pane fade" id="notes-{{ $member->id }}" role="tabpanel"
                            aria-labelledby="notes-tab">
                            <div class="mb-4">
                                @if ($member->children->count() > 0)
                                    <h6 class="d-flex align-items-center mb-3">
                                        <i class="bi bi-people me-2"></i>Anak-anak
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Nama</th>
                                                    <th class="text-center">Urutan</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($member->children as $child)
                                                    <tr>
                                                        <td class="text-center align-middle">{{ $child->nama }}</td>
                                                        <td class="text-center align-middle">
                                                            {{ $child->urutan ?? '-' }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#MemberModal{{ $child->id }}">
                                                                <i class="bi bi-eye"></i> Detail
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-muted text-center py-3">
                                        <i class="bi bi-info-circle me-1"></i>Belum memiliki anak
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($member->partners->count() > 0)
        @foreach ($member->partners as $partner)
            <div class="modal fade" id="PartnerModal{{ $partner->id }}" tabindex="-1" aria-labelledby="partnerModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="height: 600px;">
                        <div class="modal-body text-center pb-4 d-flex flex-column" style="height: 100%;">
                            @if ($partner->jenis_kelamin == 'Laki-Laki')
                                <img src="{{ asset('assets/img/avatars/laki.jpg') }}" alt="Foto Default Laki-laki"
                                    class="rounded-circle position-absolute top-0 start-50 translate-middle"
                                    style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;
                                                                                                            @if ($partner->status_kehidupan == 'Wafat') filter: grayscale(100%); @endif">
                            @elseif ($partner->jenis_kelamin == 'Perempuan')
                                <img src="{{ asset('assets/img/avatars/perempuan.jpg') }}" alt="Foto Default Perempuan"
                                    class="rounded-circle position-absolute top-0 start-50 translate-middle"
                                    style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;
                                                                                                            @if ($partner->status_kehidupan == 'Wafat') filter: grayscale(100%); @endif ">
                            @endif

                            <div class="mt-10">
                                {{ $partner->nama }}
                            </div>

                            <div class="nav nav-tabs nav-justified mt-5 mb-3" role="tablist">
                                <div class="nav-item" role="presentation">
                                    <button class="nav-link active" id="partner-bio-tab" data-bs-toggle="tab"
                                        data-bs-target="#partner-bio-{{ $partner->id }}" type="button" role="tab"
                                        aria-controls="partner-bio" aria-selected="true">
                                        Biodata
                                    </button>
                                </div>
                                <div class="nav-item" role="presentation">
                                    <button class="nav-link" id="partner-family-tab" data-bs-toggle="tab"
                                        data-bs-target="#partner-family-{{ $partner->id }}" type="button" role="tab"
                                        aria-controls="partner-family" aria-selected="false">
                                        Pasangan
                                    </button>
                                </div>
                                <div class="nav-item" role="presentation">
                                    <button class="nav-link" id="partner-children-tab" data-bs-toggle="tab"
                                        data-bs-target="#partner-children-{{ $partner->id }}" type="button" role="tab"
                                        aria-controls="partner-children" aria-selected="false">
                                        Anak
                                    </button>
                                </div>
                            </div>

                            <div class="tab-content text-start p-2 flex-grow-1" style="overflow-y: auto;">
                                <!-- Biodata Tab -->
                                <div class="tab-pane fade show active" id="partner-bio-{{ $partner->id }}" role="tabpanel"
                                    aria-labelledby="partner-bio-tab">
                                    <div class="row g-4">
                                        <div class="col mb-4">
                                            <label class="form-label">Nama</label>
                                            <div class="form-control bg-primary-hover">{{ $partner->nama }}</div>
                                        </div>
                                        <div class="col mb-4">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <div class="form-control bg-primary-hover">
                                                {{ $partner->tanggal_lahir ? \Carbon\Carbon::parse($partner->tanggal_lahir)->format('d-m-Y') : 'Belum diketahui' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col mb-4">
                                            <label class="form-label">Jenis Kelamin</label>
                                            <input type="text" class="form-control" readonly
                                                value="{{ $partner->jenis_kelamin }}">
                                        </div>
                                    </div>
                                    @if ($partner->alamat)
                                        <div class="row g-4">
                                            <div class="col mb-4">
                                                <label class="form-label">Alamat</label>
                                                <textarea class="form-control"
                                                    readonly>{{ $partner->alamat ?? 'Belum diketahui' }}</textarea>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($partner->photo)
                                        <div class="row g-4">
                                            <div class="col">
                                                <label class="form-label">Foto</label>
                                                <div class="form-control bg-primary-hover d-flex align-items-center justify-content-between"
                                                    style="cursor: pointer; border: 1px solid #ced4da; padding: 0.5rem 1rem;"
                                                    onclick="window.open('{{ $partner->photo }}', '_blank')">
                                                    <span>Buka Foto</span>
                                                    <i class="bx bx-link-external" style="font-size: 1.1rem;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Pasangan Tab -->
                                <div class="tab-pane fade" id="partner-family-{{ $partner->id }}" role="tabpanel"
                                    aria-labelledby="partner-family-tab">
                                    <div class="mb-3">
                                        <h6 class="d-flex align-items-center mb-3">
                                            <i class="bi bi-heart me-2"></i>Pasangan
                                        </h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Nama</th>
                                                        <th class="text-center">Tanggal Lahir</th>
                                                        <th class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center align-middle">{{ $member->nama }}</td>
                                                        <td class="text-center align-middle">
                                                            {{ $member->tanggal_lahir ? \Carbon\Carbon::parse($member->tanggal_lahir)->translatedFormat('d F Y') : 'Belum diketahui' }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#MemberModal{{ $member->id }}">
                                                                <i class="bi bi-eye"></i> Lihat
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Anak Tab -->
                                <div class="tab-pane fade" id="partner-children-{{ $partner->id }}" role="tabpanel"
                                    aria-labelledby="partner-children-tab">
                                    <div class="mb-4">
                                        @if ($member->children->count() > 0)
                                            <h6 class="d-flex align-items-center mb-3">
                                                <i class="bi bi-people me-2"></i>Anak-anak
                                            </h6>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Nama</th>
                                                            <th class="text-center">Urutan</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($member->children as $child)
                                                            <tr>
                                                                <td class="text-center align-middle">
                                                                    {{ $child->nama }}
                                                                </td>
                                                                <td class="text-center align-middle">
                                                                    {{ $child->urutan ?? '-' }}
                                                                </td>
                                                                <td class="text-center align-middle">
                                                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                                        data-bs-target="#MemberModal{{ $child->id }}">
                                                                        <i class="bi bi-eye"></i> Detail
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="text-muted text-center py-3">
                                                <i class="bi bi-info-circle me-1"></i>Belum memiliki anak
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <!-- Modal untuk pasangan parent -->
    @if ($member->parent && $member->parent_partner_id && $member->parent2)
        <div class="modal fade" id="PartnerModal{{ $member->parent2->id }}" tabindex="-1"
            aria-labelledby="parentPartnerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="height: 600px;">
                    <div class="modal-body text-center pb-4 d-flex flex-column" style="height: 100%;">
                        @if ($member->parent2->jenis_kelamin == 'Laki-Laki')
                            <img src="{{ asset('assets/img/avatars/laki.jpg') }}" alt="Foto Default Laki-laki"
                                class="rounded-circle position-absolute top-0 start-50 translate-middle"
                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;
                                                                                    @if ($member->parent2->status_kehidupan == 'Wafat') filter: grayscale(100%); @endif ">
                        @elseif ($member->parent2->jenis_kelamin == 'Perempuan')
                            <img src="{{ asset('assets/img/avatars/perempuan.jpg') }}" alt="Foto Default Perempuan"
                                class="rounded-circle position-absolute top-0 start-50 translate-middle"
                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;
                                                                                    @if ($member->parent2->status_kehidupan == 'Wafat') filter: grayscale(100%); @endif ">
                        @endif

                        <div class="mt-10">
                            {{ $member->parent2->nama }}
                        </div>

                        <div class="nav nav-tabs nav-justified mt-5 mb-3" role="tablist">
                            <div class="nav-item" role="presentation">
                                <button class="nav-link active" id="parent-partner-bio-tab" data-bs-toggle="tab"
                                    data-bs-target="#parent-partner-bio-{{ $member->parent2->id }}" type="button" role="tab"
                                    aria-controls="parent-partner-bio" aria-selected="true">
                                    Biodata
                                </button>
                            </div>
                            <div class="nav-item" role="presentation">
                                <button class="nav-link" id="parent-partner-family-tab" data-bs-toggle="tab"
                                    data-bs-target="#parent-partner-family-{{ $member->parent2->id }}" type="button"
                                    role="tab" aria-controls="parent-partner-family" aria-selected="false">
                                    Pasangan
                                </button>
                            </div>
                            <div class="nav-item" role="presentation">
                                <button class="nav-link" id="parent-partner-children-tab" data-bs-toggle="tab"
                                    data-bs-target="#parent-partner-children-{{ $member->parent2->id }}" type="button"
                                    role="tab" aria-controls="parent-partner-children" aria-selected="false">
                                    Anak
                                </button>
                            </div>
                        </div>

                        <div class="tab-content text-start p-2 flex-grow-1" style="overflow-y: auto;">
                            <!-- Biodata Tab -->
                            <div class="tab-pane fade show active" id="parent-partner-bio-{{ $member->parent2->id }}"
                                role="tabpanel" aria-labelledby="parent-partner-bio-tab">
                                <div class="row g-4">
                                    <div class="col mb-4">
                                        <label class="form-label">Nama</label>
                                        <div class="form-control bg-primary-hover">{{ $member->parent2->nama }}</div>
                                    </div>
                                    <div class="col mb-4">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <div class="form-control bg-primary-hover">
                                            {{ $member->parent2->tanggal_lahir ? \Carbon\Carbon::parse($member->parent2->tanggal_lahir)->format('d-m-Y') : 'Belum diketahui' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col mb-4">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $member->parent2->jenis_kelamin }}">
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col mb-4">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control"
                                            readonly>{{ $member->parent2->alamat ?? 'Belum diketahui' }}</textarea>
                                    </div>
                                </div>
                                @if ($member->parent2->photo)
                                    <div class="row g-4">
                                        <div class="col">
                                            <label class="form-label">Foto</label>
                                            <div class="form-control bg-primary-hover d-flex align-items-center justify-content-between"
                                                style="cursor: pointer; border: 1px solid #ced4da; padding: 0.5rem 1rem;"
                                                onclick="window.open('{{ $member->parent2->photo }}', '_blank')">
                                                <span>Buka Foto</span>
                                                <i class="bx bx-link-external" style="font-size: 1.1rem;"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Pasangan Tab -->
                            <div class="tab-pane fade" id="parent-partner-family-{{ $member->parent2->id }}" role="tabpanel"
                                aria-labelledby="parent-partner-family-tab">
                                <div class="mb-3">
                                    <h6 class="d-flex align-items-center mb-3">
                                        <i class="bi bi-heart me-2"></i>Pasangan
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Nama</th>
                                                    <th class="text-center">Tanggal Lahir</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center align-middle">{{ $member->parent->nama }}</td>
                                                    <td class="text-center align-middle">
                                                        {{ $member->parent->tanggal_lahir ? \Carbon\Carbon::parse($member->parent->tanggal_lahir)->translatedFormat('d F Y') : 'Belum diketahui' }}
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#MemberModal{{ $member->parent->id }}">
                                                            <i class="bi bi-eye"></i> Lihat
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Anak Tab -->
                            <div class="tab-pane fade" id="parent-partner-children-{{ $member->parent2->id }}"
                                role="tabpanel" aria-labelledby="parent-partner-children-tab">
                                <div class="mb-4">
                                    @if ($member->parent->children->count() > 0)
                                        <h6 class="d-flex align-items-center mb-3">
                                            <i class="bi bi-people me-2"></i>Anak-anak
                                        </h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Nama</th>
                                                        <th class="text-center">Urutan</th>
                                                        <th class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($member->parent->children as $child)
                                                        <tr>
                                                            <td class="text-center align-middle">
                                                                {{ $child->nama }}
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                {{ $child->urutan ?? '-' }}
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                                    data-bs-target="#MemberModal{{ $child->id }}">
                                                                    <i class="bi bi-eye"></i> Detail
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-muted text-center py-3">
                                            <i class="bi bi-info-circle me-1"></i>Belum memiliki anak
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</li>