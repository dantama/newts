<div class="table-responsive mb-4">
    @foreach ($component->meta->tables ?? [] as $i => $tbl)
        @php($_responses = $responses[$tbl->id])
        <label for="tabel-{{ $i }}" class="px-4 py-4">{{ $tbl->name }}</label>
        <table class="table-calculation mb-0 table align-middle" id="tabel-{{ $i }}">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Pertanyaan</th>
                    @if ($respondens->count() > 0)
                        @foreach ($_responses as $k => $v)
                            <th class="d-none d-lg-table-cell text-center">ID - {{ $k }}</th>
                        @endforeach
                    @endif
                    <th class="text-center">Rerata</th>
                    <th class="text-center">Grade</th>
                    <th class="text-center">Bukti/Komentar</th>
                    <th class="text-center">Deskripsi</th>
                </tr>
            </thead>
            <tbody class="calc-tbody-{{ $i }}">
                @foreach ($questions->where('table_id', $tbl->id ?? [])->sortBy('id') as $question)
                    <tr class="calc-row-{{ $i }}">
                        <td valign="top" width="3%" class="text-center">{{ $loop->iteration }}</td>
                        <td valign="top" width="30%" class="options main-option" data-options="{{ $question->table->outputs }}" data-max="{{ $question->meta->max_score }}">{{ $question->name }}</td>
                        @if ($responses->count() > 0)
                            @php($_responses = $responses[$tbl->id])
                            @foreach ($_responses as $k => $v)
                                @php($data = $v->firstWhere('question_id', $question->id))
                                @php($score = isset($data) ? $data['score'] : '')
                                @php($kpi = collect($question['meta'])['kpi'])
                                @php($target = collect($question['meta'])['target'])
                                @php($max = collect($question['meta'])['max_score'])
                                @php($r = isset($score) && $score == 0 ? 0 : (isset($score) && $score > 0 ? (($score * $kpi) / ($target * $kpi)) * $max : ''))
                                @php($class = $score > 0 ? '' : ($score == 0 ? '' : 'disabled'))
                                <td valign="top" width="5%" class="d-none d-lg-table-cell">
                                    <input type="number" class="form-control changeable-{{ $i }} bg-transparent text-center" name="resume[item][{{ $tbl->id }}][data][{{ $question->id }}][score][{{ $k }}]" value="{{ $r }}" onwheel="renderCalculation(this)" onkeyup="renderCalculation(this)" {{ $class }}>
                                </td>
                            @endforeach
                        @endif
                        <td valign="top" width="5%">
                            <input type="number" class="form-control calc-all calc-avg-{{ $i }} bg-transparent text-center" name="resume[item][{{ $tbl->id }}][data][{{ $question->id }}][total]" value="" data-max="{{ $max }}" readonly />
                            <input type="number" class="form-control max-item calc-max-item-{{ $i }} d-none bg-transparent text-center" name="resume[item][{{ $tbl->id }}][data][{{ $question->id }}][maxitem]" value="{{ $max }}" readonly />
                        </td>
                        <td valign="top" width="5%">
                            <input type="text" class="form-control grade bg-transparent text-center" name="resume[item][{{ $tbl->id }}][data][{{ $question->id }}][grade]" value="" readonly />
                        </td>
                        <td valign="top" width="20%">
                            @php($alldata = $responses->flatten()->where('question_id', $question->id) ?? [])
                            @php($metadata = $alldata->pluck('meta.description')->flatten())
                            @php($filtered = json_encode(breakThis($metadata)))
                            <textarea class="form-control evidence bg-transparent" name="resume[item][{{ $tbl->id }}][data][{{ $question->id }}][evidence]" id="" rows="2">
                            <ol> @foreach (json_decode($filtered) as $item)
<li>{{ $item->content ?? '' }}</li>
@endforeach </ol>
                            </textarea>
                        </td>
                        <td valign="top" width="20%">
                            <textarea class="form-control description bg-transparent" name="resume[item][{{ $tbl->id }}][data][{{ $question->id }}][description]" id="" rows="2" readonly></textarea>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td class="fw-bold">Sub total</td>
                    @foreach ($_responses as $k => $v)
                        @if ($v->count() > 0)
                            <td></td>
                        @endif
                    @endforeach
                    <td>
                        <input type="text" class="form-control calc-subtotal sub-total-{{ $i }} fw-bold text-center" name="resume[item][{{ $tbl->id }}][sub-total]" value="">
                        <input type="text" class="form-control calc-maxsubtotal sub-max-subtotal-{{ $i }} d-none fw-bold text-center" name="resume[item][{{ $tbl->id }}][max-sub-total]" value="">
                    </td>
                    <td>
                        <input type="text" class="form-control calc-percent sub-percent-{{ $i }} fw-bold text-center" name="resume[item][{{ $tbl->id }}][sub-percent]" value="{{ $tbl->weight }}">
                    </td>
                    <td colspan="2">
                        <input type="text" class="form-control calc-avg sub-average-total-{{ $i }} fw-bold text-center" name="resume[item][{{ $tbl->id }}][sub-average-total]" value="">
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach
</div>
<div class="card card-body">
    <div class="row border-bottom mb-3 mt-0">
        <label class="col-lg-2 col-xl-2 col-form-label fw-bold">Kesimpulan</label>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-6 col-lg-4 col-sm-12">
                <div class="required mb-4">
                    <label class="col-lg-4 col-sm-12 col-form-label">Perolehan skor</label>
                    <div class="col-xl-8 col-xxl-8">
                        <input type="number" min="0" class="form-control @error('resume[total]') is-invalid @enderror" name="resume[total]" readonly required>
                        @error('resume[total]')
                            <small class="text-danger d-block"> {{ $message }} </small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-sm-12">
                <div class="required mb-4">
                    <label class="col-lg-4 col-sm-12 col-form-label">Skor maksimal</label>
                    <div class="col-xl-8 col-xxl-8">
                        <input type="number" min="0" class="form-control @error('resume[maxtotal]') is-invalid @enderror" name="resume[maxtotal]" readonly required>
                        @error('resume[maxtotal]')
                            <small class="text-danger d-block"> {{ $message }} </small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-sm-12">
                <div class="required mb-4">
                    <label class="col-lg-4 col-sm-12 col-form-label">Total bobot</label>
                    <div class="col-xl-8 col-xxl-8">
                        <input type="number" min="0" class="form-control @error('resume[percent]') is-invalid @enderror" name="resume[percent]" readonly required>
                        @error('resume[percent]')
                            <small class="text-danger d-block"> {{ $message }} </small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-sm-12">
                <div class="required mb-4">
                    <label class="col-lg-4 col-sm-12 col-form-label">Rerata</label>
                    <div class="col-xl-8 col-xxl-8">
                        <input type="number" min="0" step="0.01" class="form-control @error('resume[average]') is-invalid @enderror" name="resume[average]" readonly required>
                        @error('resume[average]')
                            <small class="text-danger d-block"> {{ $message }} </small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-sm-12">
                <div class="required mb-4">
                    <label class="col-lg-4 col-sm-12 col-form-label">Nilai terbobot</label>
                    <div class="col-xl-8 col-xxl-8">
                        <input type="number" min="0" step="0.01" class="form-control @error('resume[averagetotal]') is-invalid @enderror" name="resume[averagetotal]" readonly required>
                        @error('resume[averagetotal]')
                            <small class="text-danger d-block"> {{ $message }} </small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-sm-12">
                <div class="required mb-4">
                    <label class="col-lg-4 col-sm-12 col-form-label">Grade</label>
                    <div class="col-xl-8 col-xxl-8">
                        <input type="text" min="0" class="form-control @error('resume[grade]') is-invalid @enderror" name="resume[grade]" readonly required>
                        @error('resume[grade]')
                            <small class="text-danger d-block"> {{ $message }} </small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="required mb-4">
        <label class="col-lg-2 col-sm-12 col-form-label">Keterangan</label>
        <div class="col-xl-12 col-xxl-12">
            <textarea class="form-control @error('resume[description]') is-invalid @enderror" name="resume[description]" rows="4" readonly required></textarea>
            @error('resume[description]')
                <small class="text-danger d-block"> {{ $message }} </small>
            @enderror
        </div>
    </div>
</div>
@if (Auth::user()->employee->id == $component->evaluation_employee->meta?->evaluator)
    <button type="submit" class="btn btn-soft-danger ml-4 mt-4"><i class="mdi mdi-check"></i> Simpan</button>
@endif
