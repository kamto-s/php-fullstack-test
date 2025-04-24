<div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="clientForm">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="is_project" class="form-label">is_project</label>
                        <select class="form-select" name="is_project" id="is_project">
                            <option value="" selected disabled>Select</option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="self_capture" class="form-label">self_capture</label>
                        <select class="form-select" name="self_capture" id="self_capture">
                            <option value="" selected disabled>Select</option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="client_prefix" class="form-label">client_prefix</label>
                        <input type="text" class="form-control" id="client_prefix" name="client_prefix"
                            max="4" min="4">
                    </div>
                    <div class="mb-3">
                        <label for="client_logo" class="form-label">client_logo (Max 2MB)</label>
                        <input type="file" class="form-control" id="client_logo" name="client_logo"
                            accept="image/jpeg,image/png,image/jpg,image/webp">
                        <img class="mt-2 img-thumbnail" id="logo-preview" src="" alt=""
                            style="max-height: 100px;">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">address</label>
                        <textarea class="form-control" name="address" id="address" cols="30" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">phone_number</label>
                        <input type="number" class="form-control" id="phone_number" name="phone_number">
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">city</label>
                        <input type="text" class="form-control" id="city" name="city">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnSubmit"></button>
                </div>
            </form>
        </div>
    </div>
</div>
