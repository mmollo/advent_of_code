defmodule A do
    def create_input(filename) do
        File.read!(filename)
        |> String.trim
        |> String.split("\n", trim: true)
    end

    def resolve(input) when is_list(input) do
        resolve(input, 5, [])
        |> Enum.join
    end

    def resolve([h|t], position, code) do
        position = find_position(position, h)
        resolve(t, position, code ++ [position])
    end

    def resolve([], _, code), do: code

    def find_position(position, <<direction, rest::binary>>) do
        find_position(move(position, <<direction>>), rest)
    end

    def find_position(position, <<>>), do: position

    defp move(position, "U") do
        cond do
            position in [1,2,3] -> position
            true -> position - 3
        end
    end

    defp move(position, "D") do
        cond do
            position in [7,8,9] -> position
            true -> position + 3
        end
    end

    defp move(position, "R") do
        cond do
            position in [3,6,9] -> position
            true -> position + 1
        end
    end

    defp move(position, "L") do
        cond do
            position in [1,4,7] -> position
            true -> position - 1
        end
    end    

end

A.create_input("input")
|> A.resolve
|> IO.inspect