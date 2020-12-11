<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pembangunan extends Model
{
    /**
     * Define table name
     *
     * @var string
     */
    protected $table = 'pembangunan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'nilai_kontrak',
        'panjang_pekerjaan',
        'desa_id',
        'volume',
        'nilai_pagu',
        'tahun'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    public $appends = [
        'coordinate', 'map_popup_content',
    ];

    /**
     * Get pembangunan name_link attribute.
     *
     * @return string
     */
    public function getNameLinkAttribute()
    {
        try {
            $title = __('app.show_detail_title', [
                'name' => $this->name, 'type' => __('pembangunan.pembangunan'),
            ]);
            $link = '<a href="'.route('pembangunan.show', $this).'"';
            $link .= ' title="'.$title.'">';
            $link .= $this->name;
            $link .= '</a>';

        } catch (\Throwable $th) {
            return;

        }
    }

    /**
     * Get pembangunan coordinate attribute.
     *
     * @return string|null
     */
    public function getCoordinateAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return $this->latitude.', '.$this->longitude;
        }
    }

    /**
     * Get pembangunan map_popup_content attribute.
     *
     * @return string
     */
    public function getMapPopupContentAttribute()
    {
        $mapPopupContent = '';
        $mapPopupContent .= '<div class="my-2"><strong>'.('Nama Pekerjaan ').':</strong><br>'.$this->name_link.'</div>';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('pembangunan.coordinate').':</strong><br>'.$this->coordinate.'</div>';
        $mapPopupContent .= '<div class="my-2"><strong>'.('lokasi').':</strong><br>'.$this->lokasi.'</div>';
        return $mapPopupContent;
    }

    /**
     * Relationship to `desas` table
     *
     * @return mixed
     */
    public function desa() {
        return $this->belongsTo(Desa::class)->withDefault();
    }

    /**
     * Filter by `tahun`
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param int $tahun
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeTahun($query, $tahun)
    {
        return $query->whereBetween('tahun', [ $tahun, $tahun ]);
    }

    /**
     * Searching data from datatable
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string|null $search
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeSearchTable($query, $search = null)
    {
        if (!empty($search)) {
            $search_term = '%' . $search . '%';

            return $query->where( function($query) use ($search_term) {
                $query->where('name', 'like', $search_term)
                    ->orWhere('address', 'like', $search_term)
                    ->orWhere('nilai_kontrak', 'like', $search_term)
                    ->orWhere('tahun', 'like', $search_term)
                    ->orWhere('panjang_pekerjaan', 'like', $search_term);
            });
        }

        return;
    }
}
