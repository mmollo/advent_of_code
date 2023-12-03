defmodule CPU do
    defstruct cycle: 0, register: 0

    use GenServer
    
    def start_link(opts \\ []) do
        GenServer.start_link(__MODULE__, opts)
    end

    def init(_opts) do
        {:ok, %CPU{}}
    end
    
    def call(cpu, :noop) do
        GenServer.cast(cpu, :noop)
    end
    
    def call(cpu, :addx, n) do
        GenServer.cast(cpu, {:addx, n})
    end
    
    def state(cpu) do
        GenServer.call(cpu, :state)
    end
    
    
    def handle_call(:state, _from, state) do
        {:reply, state, state}
    end
    
    def handle_cast(:noop, state) do
        {:noreply, tick(state)}
    end
    
    def handle_cast({:addx, n}, state) do
        {:noreply, tick(state)}
    end
    
    def tick(state) do
        %{state | cycle: state.cycle + 1}
    end
end

defmodule ACPU do
    use CPU
    
    def tick(state) do
        IO.puts "ok"
    end
end
