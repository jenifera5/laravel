<?PHP

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    public function albarans()
    {
        return $this->hasMany(Albaran::class, 'price_id');
    }
}
