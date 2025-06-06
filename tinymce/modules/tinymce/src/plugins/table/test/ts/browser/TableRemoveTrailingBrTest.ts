import { context, describe, it } from '@ephox/bedrock-client';
import { TinyAssertions, TinyHooks } from '@ephox/wrap-mcagar';

import Editor from 'tinymce/core/api/Editor';
import Plugin from 'tinymce/plugins/table/Plugin';

import * as TableTestUtils from '../module/test/TableTestUtils';

describe('browser.tinymce.plugins.table.TableRemoveTrailingBrTest', () => {
  const baseSettings = {
    plugins: 'table code',
    base_url: '/project/tinymce/js/tinymce',
    table_default_attributes: { },
    table_default_styles: { width: '200px' },
    table_sizing_mode: 'fixed'
  };

  context('remove_trailing_brs: true', () => {
    const hook = TinyHooks.bddSetup<Editor>({ ...baseSettings, remove_trailing_brs: true }, [ Plugin ], true);
    const tableOutputHtmlStr = [
      '<table style="width: 200px;"><colgroup><col style="width: 100px;"><col style="width: 100px;"></colgroup>',
      '<tbody>',
      '<tr>',
      '<td>&nbsp;</td>',
      '<td>&nbsp;</td>',
      '</tr>',
      '<tr>',
      '<td>&nbsp;</td>',
      '<td>&nbsp;</td>',
      '</tr>',
      '</tbody>',
      '</table>',
      '<p>&nbsp;</p>'
    ].join('\n');

    it('TBA: serialised content should have nbsp\'s in table cells', async () => {
      const editor = hook.editor();
      editor.setContent('');
      await TableTestUtils.pInsertTableViaGrid(editor, 2, 2);
      TinyAssertions.assertContent(editor, tableOutputHtmlStr);
    });

    it('TINY-3909: should have correct cursor position for single table', async () => {
      const editor = hook.editor();
      editor.setContent('');
      await TableTestUtils.pInsertTableViaGrid(editor, 2, 2);
      TinyAssertions.assertCursor(editor, [ 0, 1, 0, 0 ], 0);
    });

    it('TINY-3909: should have correct cursor position for nested table, no brs', async () => {
      const editor = hook.editor();
      editor.setContent('');
      await TableTestUtils.pInsertTableViaGrid(editor, 2, 2);
      await TableTestUtils.pInsertTableViaGrid(editor, 2, 2);
      TinyAssertions.assertCursor(editor, [ 0, 1, 0, 0, 0, 1, 0, 0 ], 0);
    });

    it('TINY-9860: should have correct number of non-bogus brs for single table', async () => {
      const editor = hook.editor();
      editor.setContent('');
      await TableTestUtils.pInsertTableViaGrid(editor, 2, 2);
      TinyAssertions.assertCursor(editor, [ 0, 1, 0, 0 ], 0);
      // Four brs for the table plus one after the table
      TinyAssertions.assertContentPresence(editor, { 'br': 5, 'br:not([data-mce-bogus])': 4 });
    });

    it('TINY-9860: should have correct number of non-bogus brs for nested table', async () => {
      const editor = hook.editor();
      editor.setContent('');
      await TableTestUtils.pInsertTableViaGrid(editor, 2, 2);
      await TableTestUtils.pInsertTableViaGrid(editor, 2, 2);
      // Three brs for the outer table and four brs for the inner table plus one after the table
      TinyAssertions.assertContentPresence(editor, { 'br': 8, 'br:not([data-mce-bogus])': 7 });
    });
  });

  context('remove_trailing_brs: false', () => {
    const hook = TinyHooks.bddSetup<Editor>({ ...baseSettings, remove_trailing_brs: false }, [ Plugin ], true);
    const tableOutputHtmlStr = [
      '<table style="width: 200px;"><colgroup><col style="width: 100px;"><col style="width: 100px;"></colgroup>',
      '<tbody>',
      '<tr>',
      '<td><br></td>',
      '<td><br></td>',
      '</tr>',
      '<tr>',
      '<td><br></td>',
      '<td><br></td>',
      '</tr>',
      '</tbody>',
      '</table>',
      '<p>&nbsp;</p>'
    ].join('\n');

    it('TBA: serialised content should have br\'s in table cells', async () => {
      const editor = hook.editor();
      editor.setContent('');
      await TableTestUtils.pInsertTableViaGrid(editor, 2, 2);
      TinyAssertions.assertContent(editor, tableOutputHtmlStr);
    });

    it('TINY-3909: should have correct cursor position for single table', async () => {
      const editor = hook.editor();
      editor.setContent('');
      await TableTestUtils.pInsertTableViaGrid(editor, 2, 2);
      TinyAssertions.assertCursor(editor, [ 0, 1, 0, 0 ], 0);
    });

    it('TINY-3909: should have correct cursor position for nested table', async () => {
      const editor = hook.editor();
      editor.setContent('');
      await TableTestUtils.pInsertTableViaGrid(editor, 2, 2);
      await TableTestUtils.pInsertTableViaGrid(editor, 2, 2);
      TinyAssertions.assertCursor(editor, [ 0, 1, 0, 0, 0, 1, 0, 0 ], 0);
    });

    it('TINY-9860: should have correct number of non-bogus brs for single table', async () => {
      const editor = hook.editor();
      editor.setContent('');
      await TableTestUtils.pInsertTableViaGrid(editor, 2, 2);
      TinyAssertions.assertCursor(editor, [ 0, 1, 0, 0 ], 0);
      // Four brs for the table plus one after the table
      TinyAssertions.assertContentPresence(editor, { 'br': 5, 'br:not([data-mce-bogus])': 4 });
    });

    it('TINY-9860: should have correct number of non-bogus brs for nested table', async () => {
      const editor = hook.editor();
      editor.setContent('');
      await TableTestUtils.pInsertTableViaGrid(editor, 2, 2);
      await TableTestUtils.pInsertTableViaGrid(editor, 2, 2);
      // Three brs for the outer table and four brs for the inner table plus one after the table
      TinyAssertions.assertContentPresence(editor, { 'br': 8, 'br:not([data-mce-bogus])': 7 });
    });
  });
});
