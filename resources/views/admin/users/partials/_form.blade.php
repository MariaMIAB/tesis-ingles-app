<div class="row">
    <!-- Columna izquierda -->
    <div class="col-6">
        <div class="form-group">
            <label for="name">Nombre Completo</label>
            <input id="name" name="name" type="text" placeholder="nombres apellido paterno-materno" class="form-control form-control-sm"
                value="{{ old('name', $user->name) }}" required autocomplete="name" />
            @error('name')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input id="email" name="email" type="email" placeholder="email@example.com"
                class="form-control form-control-sm" value="{{ old('email', $user->email) }}" required />
            @error('email')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="avatar" class="form-label">Imagen de Perfil</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="avatar" name="avatar">
                <label class="custom-file-label" for="avatar">Selecciona una imagen</label>
            </div>
            @error('avatar')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="roles">Rol</label>
            <select name="role" class="custom-select">
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        @if (Route::currentRouteName() == 'users.create')
        <div class="row">
            <div class="form-group col-6">
                <label for="password">Contraseña</label>
                <input id="password" name="password" type="password" class="form-control form-control-sm" />
                @error('password')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-6">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control form-control-sm" />
            </div>
        </div>
        @endif
    </div>
</div>