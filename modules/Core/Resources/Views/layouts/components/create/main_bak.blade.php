<div class="table-responsive">
    <table class="mb-0 table align-middle">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Pertanyaan</th>
                @if ($responses->count() > 0)
                    @foreach ($responses as $k => $v)
                        <th class="text-center">ID - {{ $k }}</th>
                    @endforeach
                @endif
                <th class="text-center">Rerata</th>
                <th class="text-center">Grade</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">Bukti</th>
            </tr>
        </thead>
        <tbody class="calc-tbody">
            @foreach ($questions as $label => $_questions)
                <tr>
                    <td colspan="100%">
                        {{ $label }}
                    </td>
                </tr>
                @foreach ($_questions as $question)
                    <tr class="calc-row">
                        <td valign="top" width="3%" class="text-center">{{ $loop->iteration }}</td>
                        {{-- add meta --}}
                        <td valign="top" width="30%" class="options" data-options="{{ $question->table->outputs }}" data-max="{{ $question->meta->max_score }}">{{ $question->name }}</td>
                        @if ($responses->count() > 0)
                            @foreach ($responses as $k => $v)
                                @php($data = $v->firstWhere('question_id', $question->id))
                                @php($score = isset($data) ? $data['score'] : '')
                                @php($kpi = collect($question['meta'])['kpi'])
                                @php($target = collect($question['meta'])['target'])
                                @php($max = collect($question['meta'])['max_score'])
                                @php($r = isset($score) && $score == 0 ? 0 : (isset($score) && $score > 0 ? (($score * $kpi) / ($target * $kpi)) * $max : ''))
                                @php($class = $score > 0 ? '' : ($score == 0 ? '' : 'disabled'))
                                <td valign="top" width="5%">
                                    <input type="number" class="form-control changeable bg-transparent text-center" name="resume[item][{{ $question->id }}][score][{{ $k }}]" value="{{ $r }}" onwheel="renderCalculation(this)" onkeyup="renderCalculation(this)" {{ $class }}>
                                </td>
                            @endforeach
                        @endif
                        <td valign="top" width="5%">
                            <input type="number" class="form-control calc-avg bg-transparent text-center" name="resume[item][{{ $question->id }}][total]" value="" readonly />
                        </td>
                        <td valign="top" width="5%">
                            <input type="text" class="form-control grade bg-transparent text-center" name="resume[item][{{ $question->id }}][grade]" value="" readonly />
                        </td>
                        <td valign="top" width="15%">
                            <textarea class="form-control description bg-transparent" name="resume[item][{{ $question->id }}][description]" id="" rows="2" readonly></textarea>
                        </td>
                        <td valign="top">
                            @php($alldata = $responses->flatten()->where('question_id', $question->id) ?? [])
                            @php($metadata = $alldata->pluck('meta.evidence')->flatten())
                            @php($filtered = array_unique($metadata->toArray()))
                            @php(sort($filtered))
                            <div class="form-control text-area" contenteditable="false">
                                <ol>
                                    @foreach ($filtered as $item)
                                        @if (is_numeric($item))
                                            <li>{{ $question->evidence[$item] ?? '' }}</li>
                                        @endif
                                    @endforeach
                                </ol>
                            </div>
                            <input type="text" class="form-control d-none bg-transparent text-center" name="resume[item][{{ $question->id }}][evidence]" value="{{ json_encode($filtered, JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK) }}" readonly />
                        </td>
                    </tr>
                @endforeach
            @endforeach
            <tr>
                <td></td>
                <td class="fw-bold">Total score</td>
                @foreach ($responses as $k => $v)
                    @if ($v->count() > 0)
                        <td></td>
                    @endif
                @endforeach
                <td>
                    <input type="text" class="form-control fw-bold text-center" name="resume[total]" value="">
                </td>
                <td>
                    <input type="text" class="form-control fw-bold text-center" name="resume[grade]" value="">
                </td>
                <td>
                    <textarea class="form-control fw-bold" name="resume[description]" id="" rows="1"></textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<button type="submit" class="btn btn-soft-danger ml-4 mt-4"><i class="mdi mdi-check"></i> Simpan</button>
