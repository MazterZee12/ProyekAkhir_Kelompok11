<div class="mb-3">
    <label class="form-label">Day</label>
    <input type="text" name="day" class="form-control"
        value="{{ old('day', $schedule->day ?? '') }}"
        placeholder="e.g. Monday, Tuesday - Sunday" required>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Open Time</label>
            <input type="time" name="open_time" class="form-control"
                value="{{ old('open_time', isset($schedule) ? \Carbon\Carbon::parse($schedule->open_time)->format('H:i') : '') }}"
                lang="en" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Close Time</label>
            <input type="time" name="close_time" class="form-control"
                value="{{ old('close_time', isset($schedule) ? \Carbon\Carbon::parse($schedule->close_time)->format('H:i') : '') }}"
                lang="en" required>
        </div>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Capacity</label>
    <input type="number" name="capacity" class="form-control"
        value="{{ old('capacity', $schedule->capacity ?? '') }}" min="0">
    <small class="text-muted">Maximum visitors per day</small>
</div>
<div class="mb-3">
    <label class="form-label">Best Time to Visit</label>
    <input type="text" name="best_time" class="form-control"
        value="{{ old('best_time', $schedule->best_time ?? '') }}"
        placeholder="e.g. Early morning 07.00 - 09.00">
</div>
<div class="mb-3">
    <label class="form-label">Parking Information</label>
    <textarea name="parking_info" class="form-control" rows="3">{{ old('parking_info', $schedule->parking_info ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Transportation Information</label>
    <textarea name="transport_info" class="form-control" rows="3">{{ old('transport_info', $schedule->transport_info ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Route Information</label>
    <textarea name="route_info" class="form-control" rows="3">{{ old('route_info', $schedule->route_info ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Weather Widget Embed</label>
    <textarea name="weather_embed" class="form-control" rows="4">{{ old('weather_embed', $schedule->weather_embed ?? '') }}</textarea>
    <small class="text-muted">
        Paste embed code dari
        <a href="https://weatherwidget.io" target="_blank">weatherwidget.io</a>.
        Contoh lokasi Toba:
        <code>https://forecast7.com/en/2d3599d28/toba-regency/</code>
    </small>
</div>
<div class="mb-3">
    <div class="form-check">
        <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
            {{ old('is_active', $schedule->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
    </div>
</div>
