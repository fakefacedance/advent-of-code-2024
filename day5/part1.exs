defmodule Sln do
  def part1() do
    File.read!("./input.txt")
    |> String.split("\n\n")
    |> then(fn [rules, updates] ->
      [
        String.split(rules, "\n", trim: true) |> parse_rules(),
        String.split(updates, "\n", trim: true) |> Enum.map(fn x -> String.split(x, ",") end)
      ]
    end)
    |> then(fn [rules, updates] -> get_valid_updates(updates, rules) end)
    |> Enum.map(&(Enum.at(&1, div(length(&1), 2)) |> String.to_integer()))
    |> Enum.reduce(fn mid_num, acc -> acc + mid_num end)
  end

  def parse_rules(rules, map \\ %{})
  def parse_rules([], map), do: map

  def parse_rules(rules, map) do
    [x, y] = String.split(hd(rules), "|")
    map = Map.put(map, y, [x | Map.get(map, y, [])])
    parse_rules(tl(rules), map)
  end

  def get_valid_updates(updates, rules) do
    Enum.filter(updates, fn update -> is_valid(Enum.reverse(update), rules) end)
  end

  def is_valid([_ | []], _), do: true

  def is_valid([number | rest], rules) do
    Map.has_key?(rules, number) && Enum.all?(rest, &Enum.member?(rules[number], &1)) &&
      is_valid(rest, rules)
  end
end

Sln.part1() |> IO.inspect(label: "Part 1")
