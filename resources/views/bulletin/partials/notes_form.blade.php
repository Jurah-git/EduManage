<h3 class="mb-4">
     {{ $eleve->nom }} {{ $eleve->prenom }}
</h3>

<button class="btn btn-secondary mb-3" onclick="retourListe()">

    ⬅ Retour

</button>


<div class="row">

    <!-- ================= JOURNALIER ================= -->

    <div class="col-md-6">

        <div class="card shadow">

            <div class="card-header bg-primary text-white">

                📘 Notes journalières

            </div>

            <div class="card-body">

                <form id="form-journalier" action="{{ route('bulletin.store') }}" method="POST"
                    data-nom="{{ $eleve->nom }}" data-prenom="{{ $eleve->prenom }}"
                    data-classe="{{ $eleve->classe->nom }}">

                    @csrf

                    <input type="hidden" name="eleve_id" value="{{ $eleve->id }}">

                    <input type="hidden" name="type" value="journalier">

                    <input type="hidden" name="periode_id" class="periode-hidden-journalier">

                    <!-- CHOIX PERIODE -->

                    <div class="mb-3">

                        <label class="fw-bold">

                            Période Notes Journalières

                        </label>

                        <select class="form-control periode-select-journalier">

                            <option value="">

                                Choisir période

                            </option>

                            @foreach ($periodes as $periode)
                                <option value="{{ $periode->id }}">

                                    {{ $periode->nom }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    <table class="table table-bordered text-center">

                        <thead>

                            <tr>

                                <th>Matières</th>

                                <th>Note</th>

                                <th>Coef</th>

                                <th>Base</th>

                                <th>Appréciation</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($matieres as $matiere)
                                <tr>

                                    <td>

                                        {{ $matiere->nom }}

                                    </td>

                                    <td>

                                        <input type="number" step="0.01" class="form-control note-journalier"
                                            name="notes[{{ $matiere->id }}][valeur]"
                                            value="{{ optional($notes['journalier_' . $matiere->id][0] ?? null)->valeur }}">

                                    </td>

                                    <td>

                                        <input type="number" class="form-control coef"
                                            name="notes[{{ $matiere->id }}][coef]"
                                            value="{{ $coefficients[$matiere->id] ?? 1 }}">

                                    </td>

                                    <td>

                                        <input type="number" class="form-control"
                                            name="notes[{{ $matiere->id }}][base]"
                                            value="{{ optional($notes['journalier_' . $matiere->id][0] ?? null)->base ?? 20 }}">

                                    </td>

                                    <td class="appr">

                                        --

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                        <tfoot>

                            <tr>

                                <th>TOTAL</th>

                                <th id="total-journalier">0</th>

                                <th id="coef-journalier">0</th>

                                <th colspan="2"></th>

                            </tr>

                            <tr>

                                <th>MOYENNE</th>

                                <th id="moyenne-journalier">0</th>

                                <th colspan="3"></th>

                            </tr>

                        </tfoot>

                    </table>

                    <button class="btn btn-primary w-100 mt-3">

                        💾 Enregistrer

                    </button>

                </form>

            </div>

        </div>

    </div>

    <!-- ================= COMPOSITION ================= -->

    <div class="col-md-6">

        <div class="card shadow">

            <div class="card-header bg-success text-white">

                📗 Composition

            </div>

            <div class="card-body">

                <form id="form-composition" action="{{ route('bulletin.store') }}" method="POST"
                    data-nom="{{ $eleve->nom }}" data-prenom="{{ $eleve->prenom }}"
                    data-classe="{{ $eleve->classe->nom }}">

                    @csrf

                    <input type="hidden" name="eleve_id" value="{{ $eleve->id }}">

                    <input type="hidden" name="type" value="composition">

                    <input type="hidden" name="periode_id" class="periode-hidden-composition">

                    <!-- CHOIX PERIODE -->

                    <div class="mb-3">

                        <label class="fw-bold">

                            Période Composition

                        </label>

                        <select class="form-control periode-select-composition">

                            <option value="">

                                Choisir période

                            </option>

                            @foreach ($periodes as $periode)
                                <option value="{{ $periode->id }}">

                                    {{ $periode->nom }}

                                </option>
                            @endforeach

                        </select>

                    </div>

                    <table class="table table-bordered text-center">

                        <thead>

                            <tr>

                                <th>Matières</th>

                                <th>Note</th>

                                <th>Coef</th>

                                <th>Base</th>

                                <th>Appréciation</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($matieres as $matiere)
                                <tr>

                                    <td>{{ $matiere->nom }}</td>

                                    <td>

                                        <input type="number" step="0.01" class="form-control note-composition"
                                            name="notes[{{ $matiere->id }}][valeur]"
                                            value="{{ optional($notes['composition_' . $matiere->id][0] ?? null)->valeur }}">

                                    </td>

                                    <td>

                                        <input type="number" class="form-control coef"
                                            name="notes[{{ $matiere->id }}][coef]"
                                            value="{{ $coefficients[$matiere->id] ?? 1 }}">

                                    </td>

                                    <td>

                                        <input type="number" class="form-control"
                                            name="notes[{{ $matiere->id }}][base]"
                                            value="{{ optional($notes['composition_' . $matiere->id][0] ?? null)->base ?? 20 }}">

                                    </td>

                                    <td class="appr">

                                        --

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                        <tfoot>

                            <tr>

                                <th>TOTAL</th>

                                <th id="total-composition">0</th>

                                <th id="coef-composition">0</th>

                                <th colspan="2"></th>

                            </tr>

                            <tr>

                                <th>MOYENNE</th>

                                <th id="moyenne-composition">0</th>

                                <th colspan="3"></th>

                            </tr>

                        </tfoot>

                    </table>

                    <button class="btn btn-success w-100 mt-3">

                        💾 Enregistrer

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
