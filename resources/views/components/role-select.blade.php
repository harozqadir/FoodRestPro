<div class="col-md-4 mt-3 position-relative">
    <label for="role" class="form-label">Role</label>
    <select name="role" id="role" class="form-select">
        <option value=""></option>
        <option @selected($role == 1) value="1">Admin</option>
        <option @selected($role == 2) value="2">Server</option>
        <option @selected($role == 3) value="3">Chief</option>
        <option @selected($role == 4) value="4">Casher</option>

    </select>
    @error('role')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>