<?php
 
namespace App\Models;
 
use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Notifications\Notifiable;
 
class CustomerSites extends Model
{
 
    use HasFactory,Notifiable;
 
    protected $fillable = [
        'bank_informations_id',
        'address_id',
        'financials_id',
        'physical_informations_id',
        'business_references_id',
        'key_managements_id',
        'legal_informations_id',
        'other_documents_id',
        'documents_id',
        'customer_id',
        'status',
        'update_type',
        'customer_oracle_sync_site',
    ];
 
    protected $casts = [
        'status' => ApplicationStatus::class,
    ];
    
        public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
 
    public function address():BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
 
    public function country():HasManyThrough{
        return $this->hasManyThrough(Country::class,Address::class);
    }
 
    public function bankInformations(): HasMany
    {
        return $this->hasMany(BankInformations::class, 'bank_informations_id');
    }
 
    public function financials(): BelongsTo
    {
        return $this->belongsTo(Financials::class, 'financials_id');
    }
 
    public function physicalInformation(): BelongsTo
    {
        return $this->belongsTo(PhysicalInformations::class, 'physical_informations_id');
    }
 
 
    public function keyManagements(): BelongsTo
    {
        return $this->belongsTo(KeyManagements::class, 'key_managements_id');
    }
    public function legalInformations(): BelongsTo
    {
        return $this->belongsTo(LegalInformations::class, 'legal_informations_id');
    }
 
    public function otherDocuments(): BelongsTo
    {
        return $this->belongsTo(OtherDocuments::class, 'other_documents_id');
    }
 
    // public function country(): HasManyThrough
    // {
    //     return $this->hasManyThrough(country::class, Address::class);
    // }
    public function documents(): BelongsTo
    {
        return $this->belongsTo(Documents::class, 'documents_id');
    }
 
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
 
 