<div>
    <div wire:poll.2s class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($mesas as $mesa)
            <div class="flex flex-col bg-white rounded-xl shadow-md p-6 transition duration-300 hover:-translate-y-1 hover:shadow-xl border-l-4 {{ $mesa->votos_totales > 0 ? 'border-green-500' : 'border-yellow-400' }}">
                <div class="mb-3 pb-2 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800">Mesa N° {{ $mesa->mesa }}</h3>
                    <div class="flex items-center mt-1">
                        <div class="text-lg font-semibold {{ $mesa->votos_totales > 0 ? 'text-green-600' : 'text-gray-600' }}">
                            Total: {{ $mesa->votos_totales }} Votos
                        </div>
                        @if($mesa->votos_totales > 0)
                            <i class="fas fa-check-circle ml-2 text-green-500"></i>
                        @endif
                    </div>
                </div>
                
                @if($mesa->votos_totales > 0)
                    <div class="space-y-2">
                        @foreach($mesa->personales as $personal)
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-700">{{ $personal->nombrecompleto }}:</span>
                                <span class="bg-blue-100 text-blue-800 font-medium px-2.5 py-0.5 rounded-full">{{ $personal->pivot->votos }} Votos</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex items-center justify-center py-4 text-gray-500">
                        <i class="fas fa-clock mr-2"></i>
                        <span>Esperando votos...</span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    
    <!-- Widget de total general simplificado -->
    <div class="mt-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-600">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Total General</h2>
                    <p class="text-gray-600 mt-1">Recuento de todos los votos registrados</p>
                </div>
                <div class="flex items-center">
                    <div class="bg-blue-50 rounded-lg p-5 flex items-center">
                        <i class="fas fa-vote-yea text-blue-600 text-3xl mr-3"></i>
                        <div>
                            <p class="text-sm text-blue-600 font-medium">Total Votos</p>
                            <p class="text-4xl font-bold text-blue-800">{{ $mesas->sum('votos_totales') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center py-4 text-gray-600 text-sm">
        <p>Actualización automática cada 2 segundos</p>
    </div>
</div>