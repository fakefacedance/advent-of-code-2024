defmodule Solution do
  def part_1(reports) do
    Enum.map(reports, fn report ->
      Enum.chunk_every(report, 2, 1, :discard) |> Enum.map(fn [a, b] -> a - b end)
    end)
    |> Enum.reduce(0, fn diffs, acc ->
      acc +
        if (Enum.all?(diffs, fn x -> x > 0 end) || Enum.all?(diffs, fn x -> x < 0 end)) &&
             Enum.all?(diffs, fn x -> abs(x) >= 1 && abs(x) <= 3 end) do
          1
        else
          0
        end
    end)
  end

  def part_2(reports) do
    # TODO:
  end
end

reports =
  File.read!("./input.txt")
  |> String.split("\n", trim: true)
  |> Enum.map(fn report ->
    String.split(report, " ", trim: true) |> Enum.map(&String.to_integer/1)
  end)

Solution.part_1(reports)
|> IO.inspect(label: "safe reports (1)")
