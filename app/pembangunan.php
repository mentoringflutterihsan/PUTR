<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembangunan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table='pembangunan';

    protected $fillable = [
        'name', 'nilai_kontrak', 'latitude', 'longitude','address', 'panjang_pekerjaan','desa_id',
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
        $title = __('app.show_detail_title', [
            'name' => $this->name, 'type' => __('pembangunan.pembangunan'),
        ]);
        $link = '<a href="'.route('pembangunan.show', $this).'"';
        $link .= ' title="'.$title.'">';
        $link .= $this->name;
        $link .= '</a>';

        return $link;
    }

    /**
     * pembangunan belongs to User model relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
   

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
    public function desa(){
        return $this->belongsTo(desa::class);
    }
    
    
}
