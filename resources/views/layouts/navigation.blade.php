<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <!-- Logo/Brand -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">

            <i class="fas fa-heartbeat me-2"></i>
            MedicCitas
        </a>
        
        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    {{-- DASHBOARD --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    
                    {{-- DOCTORES (SOLO ADMIN) --}}
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('doctors.*') ? 'active' : '' }}" href="{{ route('doctors.index') }}">
                                <i class="fas fa-user-md me-1"></i> Doctores
                            </a>
                        </li>
                    @endif
                    
                    {{-- PACIENTES (SOLO ADMIN) --}}
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}" href="{{ route('patients.index') }}">
                                <i class="fas fa-users me-1"></i> Pacientes
                            </a>
                        </li>
                    @endif
                    
                    {{-- CITAS --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}" href="{{ route('appointments.index') }}">
                            <i class="fas fa-calendar-check me-1"></i> 
                            @if(Auth::user()->role === 'medico')
                                Gestión de Citas
                            @elseif(Auth::user()->role === 'paciente')
                                Mis Citas
                            @else
                                Citas
                            @endif
                        </a>
                    </li>

                    {{-- BACKUPS (SOLO ADMIN) --}}
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('backups.*') ? 'active' : '' }}" href="{{ route('backups.index') }}">
                                <i class="fas fa-database me-1"></i> Backups
                            </a>
                        </li>
                    @endif
                    
                    {{-- USER DROPDOWN --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> 
                            {{ Auth::user()->name }}
                            <span class="badge bg-light text-dark ms-2 small">
                                Role: {{ Auth::user()->role }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li class="dropdown-header">
                                <i class="fas fa-envelope me-1"></i> {{ Auth::user()->email }}
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user me-2"></i> Ver Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-edit me-2"></i> Editar Perfil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i> Registrarse
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
/* ========================================
   NAVBAR PERSONALIZADO - MedicCitas
   ======================================== */

/* Animaciones */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

/* Navbar principal */
.navbar-custom {
    background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    padding: 1rem 0;
    position: sticky;
    top: 0;
    z-index: 1030;
}

/* Logo/Brand */
.navbar-custom .navbar-brand {
    font-weight: 700;
    font-size: 1.5rem;
    color: white !important;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}

.navbar-custom .navbar-brand:hover {
    transform: scale(1.05);
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.navbar-custom .navbar-brand i {
    font-size: 1.8rem;
    animation: pulse 2s infinite;
}

/* Links de navegación */
.navbar-custom .nav-link {
    color: rgba(255, 255, 255, 0.95) !important;
    font-weight: 500;
    margin: 0 0.25rem;
    padding: 0.6rem 1rem !important;
    border-radius: 8px;
    transition: all 0.3s ease;
    position: relative;
}

.navbar-custom .nav-link:hover {
    color: white !important;
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
}

.navbar-custom .nav-link.active {
    background: rgba(255, 255, 255, 0.25);
    color: white !important;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Dropdown menu */
.navbar-custom .dropdown-menu {
    background-color: white !important;
    border: none;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    border-radius: 12px;
    margin-top: 0.75rem;
    min-width: 280px;
    padding: 0.5rem 0;
    animation: fadeInDown 0.3s ease;
    z-index: 9999 !important;
}

.navbar-custom .dropdown-header {
    padding: 1rem 1.5rem;
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 600;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    margin-bottom: 0.5rem;
}

.navbar-custom .dropdown-item {
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
    color: #333;
    font-weight: 500;
    border-radius: 6px;
    margin: 0.25rem 0.5rem;
    display: flex;
    align-items: center;
}

.navbar-custom .dropdown-item i {
    width: 25px;
    text-align: center;
    font-size: 1.1rem;
}

.navbar-custom .dropdown-item:hover {
    background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
    color: white;
    transform: translateX(5px);
}

.navbar-custom .dropdown-item.text-danger:hover {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
}

.navbar-custom .dropdown-divider {
    margin: 0.5rem 1rem;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

/* Badge en el dropdown */
.navbar-custom .badge {
    font-size: 0.7rem;
    padding: 0.35rem 0.7rem;
    border-radius: 20px;
    font-weight: 600;
}

/* Botón de cerrar sesión */
.navbar-custom .dropdown-item form {
    margin: 0;
    width: 100%;
}

.navbar-custom .dropdown-item button {
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    padding: 0;
    color: inherit;
    font: inherit;
    display: flex;
    align-items: center;
}

/* Navbar toggler (mobile) */
.navbar-custom .navbar-toggler {
    border: 2px solid rgba(255, 255, 255, 0.4);
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.navbar-custom .navbar-toggler:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.6);
}

.navbar-custom .navbar-toggler:focus {
    box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
    border-color: white;
}

.navbar-custom .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2.5' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    width: 1.5em;
    height: 1.5em;
}

/* ========================================
   RESPONSIVE - MOBILE
   ======================================== */

@media (max-width: 991px) {
    /* Menú colapsado en mobile */
    .navbar-custom .navbar-collapse {
        background: white;
        margin-top: 1rem;
        padding: 1rem;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }
    
    /* Links en mobile */
    .navbar-custom .nav-link {
        color: #333 !important;
        padding: 0.75rem 1rem !important;
        margin: 0.25rem 0;
    }
    
    .navbar-custom .nav-link:hover,
    .navbar-custom .nav-link.active {
        background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
        color: white !important;
    }
    
    /* Dropdown en mobile */
    .navbar-custom .dropdown-menu {
        border: none;
        box-shadow: none;
        padding-left: 1rem;
        margin-top: 0.5rem;
        background: #f8f9fa;
    }

    .navbar-custom .dropdown-item {
        font-size: 0.9rem;
        padding: 0.6rem 1rem;
    }

    /* Badge en mobile */
    .navbar-custom .badge {
        display: inline-block;
        margin-left: 0.5rem;
    }

    /* Brand más pequeño en mobile */
    .navbar-custom .navbar-brand {
        font-size: 1.3rem;
    }

    .navbar-custom .navbar-brand i {
        font-size: 1.5rem;
    }
}

@media (max-width: 576px) {
    .navbar-custom .navbar-brand {
        font-size: 1.2rem;
    }
    
    .navbar-custom {
        padding: 0.75rem 0;
    }
}

/* FIX: Ensure navbar is visible on desktop despite Tailwind/Bootstrap conflicts */
@media (min-width: 992px) {
    .navbar-expand-lg .navbar-collapse {
        display: flex !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
}
</style>

