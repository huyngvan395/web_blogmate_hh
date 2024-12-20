<x-sub-layout>
    <x-slot name="slot">
        <div x-data="dataChat">
            <div class="flex mt-20 relative" style="height: calc(100vh - 80px);" lazy="on-load">
                <livewire:chat.chat-list />
                <livewire:chat.chat-box :userTargetID="$userTargetID" />
            </div>
        </div>
    </x-slot>
</x-sub-layout>