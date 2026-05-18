@extends('layouts.app')

@section('content')

<style>
.notes-container {
    padding: 20px;
}

.header-eleve {
    background: #0f172a;
    color: white;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.tables {
    display: flex;
    gap: 20px;
}

.table-box {
    flex: 1;
    background: white;
    padding: 15px;
    border-radius: 12px;
    border: 1px solid #eee;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

th {
    background: #2563eb;
    color: white;
}

input {
    width: 100%;
    padding: 5px;
    text-align: center;
}

.total-box {
    margin-top: 15px;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
}

.badge-good { background: #16a34a; color: white; padding: 3px 6px; border-radius: 6px; }
.badge-mid { background: #f59e0b; color: white; padding: 3px 6px; border-radius: 6px; }
.badge-bad { background: #dc2626; color: white; padding: 3px 6px; border-radius: 6px; }
</style>

<div class="notes-container">

    <div class="header-eleve">
        <h3>{{ $eleve->nom }} {{ $eleve->prenom }}</h3>
        <small>{{ $eleve->classe->nom }}</small>
    </div>

    <form method="POST" action="{{ route('bulletin.store', $eleve->id) }}">
        @csrf

        <div class="tables">

            <!-- JOURNALIERE -->
            <div class="table-box">

                <h4>📘 Note Journalière</h4>

                <table>
                    <tr>
                        <th>Matières</th>
                        <th>Note</th>
                        <th>Coef</th>
                        <th>Base</th>
                        <th>Appréciation</th>
                    </tr>

                    @foreach($matieres as $matiere)
                    <tr>
                        <td>{{ $matiere->nom }}</td>

                        <td><input type="number" name="nj[{{ $matiere->id }}][note]" oninput="calc(this)"></td>

                        <td><input type="number" name="nj[{{ $matiere->id }}][coef]" value="1"></td>

                        <td><input type="number" name="nj[{{ $matiere->id }}][base]" value="20"></td>

                        <td class="appreciation"></td>
                    </tr>
                    @endforeach
                </table>

                <div class="total-box">
                    <span>Total: <span id="total-nj">0</span></span>
                    <span>Moyenne: <span id="moy-nj">0</span></span>
                </div>

            </div>

            <!-- COMPOSITION -->
            <div class="table-box">

                <h4>📕 Composition</h4>

                <table>
                    <tr>
                        <th>Matières</th>
                        <th>Note</th>
                        <th>Coef</th>
                        <th>Base</th>
                        <th>Appréciation</th>
                    </tr>

                    @foreach($matieres as $matiere)
                    <tr>
                        <td>{{ $matiere->nom }}</td>

                        <td><input type="number" name="comp[{{ $matiere->id }}][note]" oninput="calc(this)"></td>

                        <td><input type="number" name="comp[{{ $matiere->id }}][coef]" value="1"></td>

                        <td><input type="number" name="comp[{{ $matiere->id }}][base]" value="20"></td>

                        <td class="appreciation"></td>
                    </tr>
                    @endforeach
                </table>

                <div class="total-box">
                    <span>Total: <span id="total-comp">0</span></span>
                    <span>Moyenne: <span id="moy-comp">0</span></span>
                </div>

            </div>

        </div>

        <br>

        <button type="submit" style="background:#2563eb;color:white;padding:10px 20px;border:none;border-radius:8px;">
            💾 Enregistrer
        </button>

    </form>

</div>

<script>
function calc(el) {

    let table = el.closest("table");

    let rows = table.querySelectorAll("tr");

    let total = 0;
    let coefTotal = 0;

    rows.forEach((row, index) => {

        let note = row.querySelector("input[name*='note']");
        let coef = row.querySelector("input[name*='coef']");
        let app = row.querySelector(".appreciation");

        if(note && coef) {

            let n = parseFloat(note.value || 0);
            let c = parseFloat(coef.value || 0);

            total += n * c;
            coefTotal += c;

            if(app) {
                if(n >= 16) app.innerHTML = "Excellent";
                else if(n >= 12) app.innerHTML = "Bien";
                else if(n >= 10) app.innerHTML = "Passable";
                else app.innerHTML = "Faible";
            }
        }
    });

    let moy = coefTotal ? (total / coefTotal).toFixed(2) : 0;

    if(table.closest(".table-box").querySelector("h4").innerText.includes("Journalière")) {
        document.getElementById("total-nj").innerText = total.toFixed(2);
        document.getElementById("moy-nj").innerText = moy;
    } else {
        document.getElementById("total-comp").innerText = total.toFixed(2);
        document.getElementById("moy-comp").innerText = moy;
    }
}
</script>

@endsection