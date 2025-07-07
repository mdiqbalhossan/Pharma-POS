<div class="modal fade" id="importMedicineModal" tabindex="-1" role="dialog" aria-labelledby="importMedicineModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importMedicineModalLabel">{{ __('medicine.import_medicines') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('medicines.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info" role="alert">
                        <p>{{ __('medicine.import_instructions') }}</p>
                        <ol>
                            <li>{{ __('medicine.import_instructions_1') }}</li>
                            <li>{{ __('medicine.import_instructions_2') }}</li>
                            <li>{{ __('medicine.import_instructions_3') }}</li>
                        </ol>
                    </div>
                    <div class="form-group">
                        <label for="file" class="form-label">{{ __('medicine.select_file') }} <span
                                class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file"
                            name="file" required>
                        @error('file')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('medicines.download-sample') }}" class="btn btn-outline-info btn-sm">
                            <i data-feather="download" class="feather-download me-1"></i>
                            {{ __('medicine.download_sample') }}
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('index.close') }}</button>
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="upload" class="feather-upload me-1"></i>
                        {{ __('medicine.import') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
