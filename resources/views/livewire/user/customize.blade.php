<div>
<label for="" class="text-amber-500 font-bold md:text-4xl text-xl">CUSTOMIZE YOUR ORDER</label>
 <p class="text-red-500">*Note, After your customize product was successfully added, you can contact the ADMINISTRATOR to follow up your order</p>
 <p class="text-red-500">*How to contact ADMINISTRATOR?, Just open the messenger icon and simply search <span class="text-amber-500">"ADMINISTARTOR"</span>
    </p>
 <div class="flex flex-col justify-center p-4 gap-4">
    <x-native-select
    label="Choose Materil"
    placeholder="Select Material"
    :options="['Bamboo', 'Wood', 'Rattan']"
    wire:model="material"
 />
    <x-native-select
    label="Type of Furniture"
    placeholder="Select Furniture Type"
    :options="['Table', 'Chair', 'Bed', 'Book Cased', 'Dressers', 'Desks', 'Ottoman']"
    wire:model="furnituretype"
/>
<label for="">Preferred Design</label>
<div class="flex gap-2 ">
    <input type="file" wire:model="photo" accept="image/*" required >
  </div>

  <div>
    <x-textarea wire:model="comment" label="Comment" placeholder="Your comment" />
  </div>
<x-button icon="arrow-circle-down" amber label="Order Now" wire:click="ordernow"/>
 </div>
</div>
