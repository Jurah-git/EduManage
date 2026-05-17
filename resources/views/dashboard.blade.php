@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- HEADER -->
    <div class="mb-4">
        <h2 class="fw-bold">📊 Dashboard</h2>
        <p class="text-muted">
            Bienvenue dans <strong>EduManage</strong> 🎓 — gestion de votre école
        </p>
    </div>

    <!-- STATS -->
    <div class="row g-3">

        <!-- ÉLÈVES -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Élèves</h6>
                        <h3 class="fw-bold">{{ $totalEleves }}</h3>
                    </div>
                    <div class="icon-box bg-primary">
                        🎓
                    </div>
                </div>
            </div>
        </div>

        <!-- CLASSES -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Classes</h6>
                        <h3 class="fw-bold">{{ $totalClasses }}</h3>
                    </div>
                    <div class="icon-box bg-success">
                        🏫
                    </div>
                </div>
            </div>
        </div>

        <!-- USERS -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Utilisateurs</h6>
                        <h3 class="fw-bold">{{ $totalUsers }}</h3>
                    </div>
                    <div class="icon-box bg-warning">
                        👤
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- TABLE DERNIERS ÉLÈVES -->
    <div class="row mt-4">
        <div class="col-md-12">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h6 class="mb-0">📌 Derniers élèves ajoutés</h6>
                </div>

                <div class="card-body">

                    <table class="table table-striped text-center align-middle">

                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Classe</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach(\App\Models\Eleve::with('classe')->latest()->take(5)->get() as $eleve)
                                <tr>
                                    <td>{{ $eleve->nom }}</td>
                                    <td>{{ $eleve->prenom }}</td>
                                    <td>{{ $eleve->classe->nom ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

</div>

<!-- STYLE -->
<style>
.stat-card {
    transition: 0.3s;
    border-radius: 12px;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.icon-box {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    color: white;
}
</style>

@endsection