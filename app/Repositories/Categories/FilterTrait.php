<?php
namespace App\Repositories\Categories;
trait FilterTrait
{
   /**
   * Scope Q
   * @author sonduc <ndson1998@gmail.com>
   *
   * @param $query
   * @param $q
   *
   * @return mixed
   */
   public function scopeQ($query, $q)
   {
      if ($q) {
         return $query->where('categories.name', 'like', "%${q}%");
      }
      return $query;
   }

   /**
   * Scope Status
   * @param $query
   * @param $q
   *
   * @return mixed
   */
   public function scopeStatus($query, $q)
   {
      if (is_numeric($q)) {
         $query->where('categories.status', $q);
      }

      return $query;
   }

}
