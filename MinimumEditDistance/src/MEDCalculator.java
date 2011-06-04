import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;

/**
 * Fancy Minimal Edit Distance Calculator.
 * 
 * @author sagiemao
 * @author gittitda
 * 
 */
public class MEDCalculator {

	/**
	 * Given inserted characters, returns cost of its insertion.
	 * 
	 * @param c
	 *            Character inserted
	 * @return Insertion cost
	 */
	private static int ins_cost(char c) {
		return 1;
	}

	/**
	 * Given deleted character, returns cost of its deletion.
	 * 
	 * @param c
	 *            Character deleted
	 * @return Deletion cost
	 */
	private static int del_cost(char c) {
		return 1;
	}

	/**
	 * Given two characters replacing each other, returns cost of substitution.
	 * 
	 * @param c1
	 *            Original character
	 * @param c2
	 *            Replaced character
	 * @return Substitution cost
	 */
	private static int subst_cost(char c1, char c2) {
		if (c1 == c2) {
			return 0;
		} else {
			return 2;
		}
	}

	/**
	 * Prints a given MED table.
	 * 
	 * @param s1
	 *            Original text
	 * @param s2
	 *            New text
	 * @param table
	 *            MED table
	 */
	private static void print_table(String s1, String s2, int[][] table) {
		int length1 = s1.length() + 1;
		int length2 = s2.length() + 1;

		System.out.print("  # ");
		for (int i = 1; i < length1; i++) {
			System.out.print("" + s1.charAt(i - 1) + ' ');
		}
		System.out.println();

		for (int j = 0; j < length2; j++) {
			if (j == 0) {
				System.out.print("# ");
			} else {
				System.out.print("" + s2.charAt(j - 1) + ' ');
			}

			for (int i = 0; i < length1; i++) {
				System.out.print("" + table[i][j] + ' ');
			}
			System.out.println();
		}
		System.out.println();
	}

	/**
	 * Builds and returns MED table for two given texts
	 * 
	 * @param s1
	 *            Original text
	 * @param s2
	 *            New text
	 * @return MED table
	 */
	public static int[][] med_table(String s1, String s2) {
		int length1 = s1.length() + 1;
		int length2 = s2.length() + 1;

		int[][] table = new int[length1][length2];

		for (int i = 0; i < length1; i++) {
			table[i][0] = i * ins_cost(s1.charAt(0));
		}
		for (int i = 0; i < length2; i++) {
			table[0][i] = i * ins_cost(s2.charAt(0));
		}

		for (int j = 1; j < length2; j++) {
			for (int i = 1; i < length1; i++) {
				char c1 = s1.charAt(i - 1);
				char c2 = s2.charAt(j - 1);

				table[i][j] = Math.min(Math.min(
						table[i - 1][j] + del_cost(c2),
						table[i][j - 1] + ins_cost(c1)),
						table[i - 1][j - 1] + subst_cost(c1, c2));
			}
		}

		return table;
	}

	/**
	 * Main application procedure, expects 2 texts as arguments.
	 * 
	 * @param args
	 *            Array of 2 strings to compare
	 */
	public static void main(String[] args) {
		String s1 = null;
		String s2 = null;
		
		if (args.length == 2) {
			s1 = args[0];
			s2 = args[1];
		} else {
			System.out.println("Please input two words:");
			InputStreamReader converter = new InputStreamReader(System.in);
			BufferedReader in = new BufferedReader(converter);
			try {
				s1 = in.readLine();
				s2 = in.readLine();
			} catch (IOException e) {
				System.err.println("I/O Error!");
			}
		}
		
		if (!s1.isEmpty() && !s2.isEmpty()) {
			int[][] table = med_table(s1, s2);
	
			System.out.println(String.format(
					"Minimal Edit Distance table for %s, %s:", s1, s2));
			System.out.println();
			print_table(s1, s2, table);
	
			System.out.println(String.format("Distance = %d.",
					table[s1.length()][s2.length()]));
		}
		else {
			System.err.println("No words!");
		}
	}

}
